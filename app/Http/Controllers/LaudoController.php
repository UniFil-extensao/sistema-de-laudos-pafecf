<?php

namespace App\Http\Controllers;

use App\Models\Laudo;
use App\Models\Empresa;
use App\Models\PDV;
use App\Models\Ecfs;
use App\Models\Marca;
use App\Models\Modelo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLaudoRequest;
use App\Http\Requests\StoreLaudoUpdateRequest;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

/**
 * Classe de controle dos Laudos
 * @author Leonardo Lima
 * @version 1.0
 * @copyright NPI © 2021, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class LaudoController extends Controller
{
    /**
     * Função responsável por limitar as funções dessa classe somente para usuários logados.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Função responsável por chamar a view inicial do cadastro de laudos.
     * Se algo for escrito no campo de busca, ela retorna o resultado da busca.
     * @return view - Mostra uma listagem com todos os laudos cadastrados e podemos buscar através da variável $busca
     */
    public function index()
    {
        $buscar = request('buscar');
        if ($buscar) {
            $laudos = Laudo::where([
                ['razao_social_empresa', 'LIKE', "%{$buscar}%"]
            ])->orderBy('id', 'desc')->paginate(10);
            return view('laudo.index', ['laudos' => $laudos, 'buscar' => $buscar]);
        }
        $laudos = Laudo::where('ifl', 'LIKE', "%IFL%")->orderBy('id', 'desc')->paginate(10);
        return view('laudo.index', ['laudos' => $laudos, 'buscar' => $buscar]);
    }

    /**
     * Função responsável por chamar o formulário de cadastro de laudos.
     * @return view - Formulário de cadastro
     */
    public function create()
    {
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $empresas = Empresa::where('validacao', true)->orderBy('id', 'desc')->get();
        $pdvs = PDV::where('validacao', true)->orderBy('id', 'desc')->get();
        return view('laudo.create', ['empresas' => $empresas, 'pdvs' => $pdvs, 'marcas' => $marcas, 'modelos' => $modelos]);
    }

    /**
     * Função responsável por gerar o número do laudo corretamente, conforme o ano atual e os laudos existentes
     * @return $numero_laudo
     */
    public function gerarIFL()
    {
        $numero_laudo = 1;
        $ano_atual = Carbon::now()->year;
        $ultimo_laudo =  Laudo::latest('id')->first();
        if ($ultimo_laudo == null) {
            return $numero_laudo;
        }
        $ano_ultimo_laudo = $ultimo_laudo->select('created_at')->first();
        $ano_ultimo_laudo = \Carbon\Carbon::parse($ano_ultimo_laudo->created_at)->year;



        if ($ano_atual == $ano_ultimo_laudo) {
            $numero_laudo = $ultimo_laudo->numero_laudo + 1;
            return $numero_laudo;
        } else {
            return $numero_laudo;
        }
    }

    /**
     * Função responsável por escrever as informações cadastradas no banco de dados
     * @param \Requests\StoreLaudoRequest $request - Objeto com todas as informações preenchidas no formulário. Os campos são validados pela classe StoreLaudoRequest.
     * @return view - Volta para a página inicial do cadastro de laudos com uma mensagem de êxito.
     */
    public function store(StoreLaudoRequest $request)
    {

        $laudo = new Laudo;
        $pdv = PDV::find($request->pdv);
        $user = auth()->user();
        $ano_atual = Carbon::now()->year;

        $laudo->numero_laudo = $this->gerarIFL();

        if ($laudo->numero_laudo < 10) {
            $laudo->ifl .= "IFL00" . $laudo->numero_laudo . $ano_atual;
        } else {
            $laudo->ifl .= "IFL0" . $laudo->numero_laudo . $ano_atual;
        }

        $ecf = Ecfs::find($request->ecf_analise_modelo);

        $laudo->id_pdv = $pdv->id;
        $laudo->id_empresa = $pdv->empresa->id;
        $laudo->razao_social_empresa = $pdv->empresa->razao_social;
        $laudo->nome_comercial_pdv = $pdv->nome_comercial;
        $laudo->homologador = $user->name;
        $laudo->data_inicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_inicio)
            ->format('d/m/Y');
        $laudo->data_termino = \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_termino)
            ->format('d/m/Y');
        $laudo->versao_er = $request->versao_er;
        $laudo->envelope_seguranca_marca = $request->envelope_seguranca_marca;
        $laudo->envelope_seguranca_modelo = $request->envelope_seguranca_modelo;
        $laudo->numero_envelope = $request->numero_envelope;
        $laudo->requisitos_executados_sgbd = $request->requisitos_executados_sgbd;
        $laudo->executavel_sgbd = $request->executavel_sgbd;
        $laudo->funcao_sped = $request->funcao_sped;
        $laudo->executavel_sped = $request->executavel_sped;
        $laudo->executavel_nfe = $request->executavel_nfe;
        $laudo->parecer_conclusivo = $request->parecer_conclusivo;
        $laudo->ecf_analise_marca = $request->ecf_analise_marca;
        $laudo->ecf_analise_modelo = $ecf->modelo;
        $laudo->relacao_ecfs = implode(", ", $request->input('relacao_ecfs'));
        $laudo->comentarios = $request->comentarios;
        $laudo->responsavel_testes = $request->responsavel_testes;

        $laudo->save();

        return redirect('/laudo')->with('msg', 'Laudo Cadastrado com Sucesso!!');
    }

    /**
     * Função responsável por puxar do banco de dados todos os PDVs da empresa selecionada e
     * preencher as <option> do <select> na view.
     * @return $option
     */
    public function getPDVs()
    {
        $id_empresa = request('empresa');
        $pdvs = PDV::where([
            ['id_empresa', $id_empresa],
            ['validacao', true]
        ])->get();
        $option = "<option value=''>Selecione um PDV</option>";
        foreach ($pdvs as $pdv) {
            $option .= '<option value="' . $pdv->id . '">' . $pdv->nome_comercial . '</option>';
        }
        return $option;
    }

    /**
     * Função responsável por puxar do banco de dados todos os modelos de ECFs cadastrados
     * para as <option> no <select> da view responsável por selecionar o modelo da ecf utilizado na homologação.
     * ESTE É PARA A CADASTRO DO LAUDO
     * @return $option
     */
    public function getModelosStore()
    {
        $marca = request('ecf_analise_marca');
        // $marca_model = Marca::where([['nome', 'LIKE', $marca->nome]])->get()->first()->orderBy('nome');
        // $modelos = Modelo::where([['marca_id', '=', $marca_model->id]])->get();
        $modelos = Modelo::where([['marca_id', $marca]])->get();

        $option = "<option value=''>Selecione um Modelo</option>";
        foreach ($modelos as $modelo) {
            $option .= '<option value="' . $modelo->id . '">' . $modelo->nome . '</option>';
        }

        return $option;
    }

    /**
     * Função responsável por puxar do banco de dados todos os modelos de ECFs cadastrados
     * para as <option> no <select> da view responsável por selecionar o modelo da ecf utilizado na homologação.
     * ESTE É PARA A ATUALIZAÇÃO DO LAUDO
     * @return $option
     */
    public function getModelosUpdate()
    {
        $marcas = Marca::all();

        $option = "<option value=''>Selecione um Modelo</option>";
        foreach ($marcas as $marca) {
            $option .= '<option value="' . $marca->id . '">' . $marca->nome . '</option>';
        }

        return $option;
    }

    /**
     * Função responsável por trazer do banco o cadastro do laudo e preencher o formulário para upload.
     * @param Integer $id - identificador do laudo a ser buscado no banco de dados.
     * @return view - Formulário de cadastro do laudo com os campos preenchidos, livres para edição.
     */
    public function show($id)
    {
        $ecfs = DB::table('ecfs')->select('marca')->distinct()->get();
        $laudo = Laudo::find($id);
        $laudo->data_inicio = \Carbon\Carbon::createFromFormat('d/m/Y', $laudo->data_inicio)
            ->format('Y-m-d');
        $laudo->data_termino = \Carbon\Carbon::createFromFormat('d/m/Y', $laudo->data_termino)
            ->format('Y-m-d');
        $relacao_ecfs = Modelo::all();
        $ecfs_selecionadas = $laudo->relacao_ecfs;
        return view('laudo.show', ['laudo' => $laudo, 'ecfs' => $ecfs, 'relacao_ecfs' => $relacao_ecfs, 'ecfs_selecionadas' => $ecfs_selecionadas]);
    }

    /**
     * Atualiza o cadastro do laudo.
     * @param \Requests\StoreLaudoUpdateRequest $request - Objeto com todas as informações preenchidas no formulário. Os campos são validados pela classe StoreLaudoUpdateRequest.
     * @return view - Retorna para a mesma página com a mensagem de êxito ou de erro.
     */
    public function update(StoreLaudoUpdateRequest $request, $id)
    {
        $laudo = Laudo::find($id);
        if (
            $laudo->data_inicio == \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_inicio)
            ->format('d/m/Y') &&
            $laudo->data_termino == \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_termino)
            ->format('d/m/Y') &&
            $laudo->versao_er == $request->input('versao_er') &&
            $laudo->envelope_seguranca_marca == $request->input('envelope_seguranca_marca') &&
            $laudo->envelope_seguranca_modelo == $request->input('envelope_seguranca_modelo') &&
            $laudo->numero_envelope == $request->input('numero_envelope') &&
            $laudo->requisitos_executados_sgbd == $request->input('requisitos_executados_sgbd') &&
            $laudo->executavel_sgbd == $request->input('executavel_sgbd') &&
            $laudo->funcao_sped == $request->input('funcao_sped') &&
            $laudo->executavel_sped == $request->input('executavel_sped') &&
            $laudo->executavel_nfe == $request->input('executavel_nfe') &&
            $laudo->parecer_conclusivo == $request->input('parecer_conclusivo') &&
            $laudo->ecf_analise_marca == $request->input('ecf_analise_marca') &&
            $laudo->ecf_analise_modelo == $request->input('ecf_analise_modelo') &&
            $laudo->relacao_ecfs == implode(", ", $request->input('relacao_ecfs')) &&
            $laudo->comentarios == $request->input('comentarios') &&
            $laudo->responsavel_testes == $request->input('responsavel_testes')
        ) {
            return redirect()->back()->with('msgerro', 'Nenhum campo alterado!!');
        } else {
            $laudo->data_inicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_inicio)
                ->format('d/m/Y');
            $laudo->data_termino = \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_termino)
                ->format('d/m/Y');
            $laudo->versao_er = $request->input('versao_er');
            $laudo->envelope_seguranca_marca = $request->input('envelope_seguranca_marca');
            $laudo->envelope_seguranca_modelo = $request->input('envelope_seguranca_modelo');
            $laudo->numero_envelope = $request->input('numero_envelope');
            $laudo->requisitos_executados_sgbd = $request->input('requisitos_executados_sgbd');
            $laudo->executavel_sgbd = $request->input('executavel_sgbd');
            $laudo->funcao_sped = $request->input('funcao_sped');
            $laudo->executavel_sped = $request->input('executavel_sped');
            $laudo->executavel_nfe = $request->input('executavel_nfe');
            $laudo->parecer_conclusivo = $request->input('parecer_conclusivo');
            $laudo->ecf_analise_marca = $request->input('ecf_analise_marca');
            $laudo->ecf_analise_modelo = $request->input('ecf_analise_modelo');
            $laudo->relacao_ecfs = implode(", ", $request->input('relacao_ecfs'));
            $laudo->comentarios = $request->input('comentarios');
            $laudo->responsavel_testes = $request->input('responsavel_testes');

            $laudo->save();
            return redirect()->back()->with('msg', 'Laudo Editado com Sucesso!!');
        }
    }

    /**
     * Função responsável por excluir o registro do laudo.
     * @param Integer $id - identificador do laudo.
     * @return view - Volta para a página inicial do cadastro de laudos com uma mensagem de êxito.
     */
    public function destroy($id)
    {
        $laudo = Laudo::find($id);
        $laudo->delete();
        return redirect()->route('laudo.index')->with('msgerro', 'Laudo Excluído com Sucesso!!');
    }

    /**
     * Função que seria responsável por fazer upload dos arquivos, lê-los e preencher os <select> da view.
     * Ainda não funciona
     */
    public function carregarArquivos()
    {
        $arquivo_tmp = $_FILES['md5']['tmp_name'];
        $dados = file($arquivo_tmp);

        foreach ($dados as $linha) {
            $linha = trim($linha);
            $valor = explode(' ', $linha);
            var_dump($valor);
        }
    }

    /**
     * Função responsável por chamar a view de geração de laudo.
     * @param Integer $id_laudo - identificador do laudo a ser gerado em .doc
     * @return view - Mostra a view que gera os laudos.
     */
    public function viewGerarDocs($id_laudo)
    {
        $laudo = Laudo::find($id_laudo);
        $pdv = PDV::find($laudo->id_pdv);
        $empresa = Empresa::find($pdv->empresa->id);
        return view('laudo.gerarDocs', ['laudo' => $laudo, 'pdv' => $pdv, 'empresa' => $empresa]);
    }

    /**
     * Função responsável por gerar efetivamente o laudo em .doc.
     * @param Integer $id_laudo - identificador do laudo a ser gerado em .doc
     * @return view - Volta para a página de geração de laudos.
     */
    public function gerarLaudo($id_laudo)
    {
        $laudo = Laudo::find($id_laudo);
        $pdv = PDV::find($laudo->id_pdv);
        $ecfs = Ecfs::all();
        $empresa = Empresa::find($pdv->empresa->id);
        $templateProcessor = new TemplateProcessor('ModeloLaudoPAFECF.docx');


        $ano_atual = Carbon::now()->year;
        $dia = Carbon::now()->day;
        $mes = Carbon::now()->month;

        if ($mes == 1) {
           $mes = "Janeiro";
        } else if($mes == 2){
            $mes = "Fevereiro";
        } else if($mes == 3){
            $mes = "Março";
        } else if($mes == 4){
            $mes = "Abril";
        } else if($mes == 5){
            $mes = "Maio";
        } else if($mes == 6){
            $mes = "Junho";
        } else if($mes == 7){
            $mes = "Julho";
        } else if($mes == 8){
            $mes = "Agosto";
        } else if($mes == 9){
            $mes = "Setembro";
        } else if($mes == 10){
            $mes = "Outubro";
        } else if($mes == 11){
            $mes = "Novembro";
        } else if($mes == 12){
            $mes = "Dezembro";
        }

        $data_de_hoje = "$dia de $mes de $ano_atual";

        $marcas_ecfs = "";
        $modelos_ecfs = "";
        foreach ($ecfs as $ecf) {
            $marcas_ecfs .= $ecf->marca;
            $marcas_ecfs .= "\n";
            $modelos_ecfs .= "$ecf->modelo\n";
        }

        $templateProcessor->setValues(array(
            //informações da Empresa
            'txtCnpj' => $empresa->cnpj,
            'txtRazaoSocial' => $empresa->razao_social,
            'txtNomeFantasia' => $empresa->nome_fantasia,
            'txtEndereco' => $empresa->endereco,
            'txtBairro' => $empresa->bairro,
            'txtCidade' => $empresa->cidade,
            'txtUf' => $empresa->uf,
            'txtCep' => $empresa->cep,
            'txtTelefone' => $empresa->telefone,
            'txtCelular' => $empresa->celular,
            'txtIe' => $empresa->inscricao_estadual,
            'txtIm' => $empresa->inscricao_municipal,
            'txtRepresentante' => $empresa->representante,
            'txtCpfContato' => $empresa->cpf_representante,
            'txtRGRepresentante' => $empresa->rg_representante,
            'txtEmail' => $empresa->email_representante,
            //informações do Laudo
            'txtResponsavelTestes' => $laudo->responsavel_testes,
            'laudo' => $laudo->ifl,
            'txtNomeHomologador' => $laudo->homologador,
            'txtDataInicio' => $laudo->data_inicio,
            'txtDataFinal' => $laudo->data_termino,
            'txtEnvelope' => $laudo->numero_envelope,
            'txtEcfMarca' => $laudo->ecf_analise_marca,
            'txtEcfModelo' => $laudo->ecf_analise_modelo,
            'txtObservacaoOTC' => $laudo->comentarios,
            'txtPrincipalExec' => $pdv->nome_principal_executavel,
            'txtRelacaoMarcas' => $marcas_ecfs,
            'txtRelacaoModelos' => $modelos_ecfs,
            //pretendo pegar o sysdate
            'txtDataVersao' => $laudo->data_termino,
            //informações do PDV
            'txtNomeComercial' => $pdv->nome_comercial,
            'txtVersao' => $pdv->versao,
            'txtLinguagemProgramacao' => $pdv->linguagem,
            'txtSo' => $pdv->sistema_operacional,
            'txtBd' => $pdv->data_base,
            //Informações Doc
            'txtData' => $data_de_hoje,
        ));
        //$option .= '<option value="' . $ecf->id . '">' . $ecf->modelo . '</option>';
        $stringNomeLado = $laudo->ifl;
        $pastaParaSalvar = $stringNomeLado;
        if (!file_exists($pastaParaSalvar)) {
            mkdir($pastaParaSalvar, 0755, true);
        }
        $pastaParaSalvar .= '/'.$stringNomeLado.'.docx';
        $laudo->caminho_laudo = '/public/'.$pastaParaSalvar;
        $templateProcessor->saveAs($pastaParaSalvar);
        $laudo->save();
        return view('laudo.gerarDocs', ['laudo' => $laudo, 'pdv' => $pdv, 'empresa' => $empresa]);
    }
}
