<?php

namespace App\Http\Controllers;

use App\Models\Laudo;
use App\Models\Empresa;
use App\Models\PDV;
use App\Models\Ecfs;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\LaudosEcfs;
use App\Models\LaudosRelacaoEcfs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLaudoRequest;
use App\Http\Requests\StoreLaudoUpdateRequest;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007\Element\CheckBox as ElementCheckBox;

/**
 * Classe de controle dos Laudos
 * @author Leonardo Lima e Pedro Rocha
 * @version 2.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
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
        //dd request all
        // dd($request->all());
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

        // $ecf = Ecfs::find($request->ecf_analise_modelo);
        // $ecf_compativel = Ecfs::find($request->relacao_ecfs_modelo);

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
        $laudo->ecf_analise_marca = $request->ecf_analise_marca;
        $laudo->ecf_analise_modelo = $request->ecf_analise_modelo;
        $laudo->relacao_ecfs_marca = $request->relacao_ecfs_marca;
        $laudo->relacao_ecfs_modelo = $request->relacao_ecfs_modelo;
        $laudo->parecer_conclusivo = $request->parecer_conclusivo;
        $laudo->comentarios = $request->comentarios;
        $laudo->responsavel_testes = $request->responsavel_testes;

        $laudo->save();
        //in $request for each marca in an_marca and modelo in an_modelo find id from tables marcas and modelos
        $ecf_analise_marca = array();
        $ecf_analise_modelo = array();
        $relacao_ecfs_marca = array();
        $relacao_ecfs_modelo = array();

        foreach ($request->an_marca as $marca) {
            //append to array
            array_push($ecf_analise_marca, Marca::where('nome', $marca)->first()->id);
        }

        foreach ($request->an_modelo as $modelo) {
            //append to array
            array_push($ecf_analise_modelo, Modelo::where('nome', $modelo)->first()->id);
        }

        foreach ($request->re_marca as $marca) {
            //append to array
            array_push($relacao_ecfs_marca, Marca::where('nome', $marca)->first()->id);
        }

        foreach ($request->re_modelo as $modelo) {
            //append to array
            array_push($relacao_ecfs_modelo, Modelo::where('nome', $modelo)->first()->id);
        }

        //create new laudos_ecfs with arrays ecf_analise_marca and ecf_analise_modelo and laudo id
        foreach ($ecf_analise_marca as $index => $marca) {
            $laudo_ecf = new LaudosEcfs;
            $laudo_ecf->laudo_id = $laudo->id;
            $laudo_ecf->marca_id = $marca;
            $laudo_ecf->modelo_id = $ecf_analise_modelo[$index];
            $laudo_ecf->save();
        }

        //create new laudos_relacao_ecfs with arrays relacao_ecfs_marca and relacao_ecfs_modelo and laudo id
        foreach ($relacao_ecfs_marca as $index => $marca) {
            $laudo_relacao_ecf = new LaudosRelacaoEcfs;
            $laudo_relacao_ecf->laudo_id = $laudo->id;
            $laudo_relacao_ecf->marca_id = $marca;
            $laudo_relacao_ecf->modelo_id = $relacao_ecfs_modelo[$index];
            $laudo_relacao_ecf->save();
        }

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
     * ESTE É PARA O CADASTRO DO LAUDO
     * @return $option
     */
    public function getModelosStore()
    {
        $marca = request('ecf_analise_marca');
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
     * ESTE É PARA O CADASTRO DO LAUDO
     * @return $option
     */
    public function getModelosAnaliseStore()
    {
        $marca = request('relacao_ecfs_marca');
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
        $marca = request('ecf_analise_marca');
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
    public function getModelosAnaliseUpdate()
    {
        $marca = request('relacao_ecfs_marca');
        $modelos = Modelo::where([['marca_id', $marca]])->get();

        $option = "<option value=''>Selecione um Modelo</option>";
        foreach ($modelos as $modelo) {
            $option .= '<option value="' . $modelo->id . '">' . $modelo->nome . '</option>';
        }

        return $option;
    }

    /**
     * Função responsável por trazer, do banco, o cadastro do laudo e preencher o formulário para upload.
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
        $ecf_analise_marca = Marca::all();
        $ecf_analise_modelo = Modelo::all();
        $relacao_ecfs_marca = Marca::all();
        $relacao_ecfs_modelo = Modelo::all();
        //get marcas and modelos used in the laudo with LaudosEcfs
        $laudo_ecfs = LaudosEcfs::where('laudo_id', $id)->get();
        $an_marca = [];
        $an_modelo = [];
        foreach ($laudo_ecfs as $laudo_ecf) {
            $marca = Marca::find($laudo_ecf->marca_id);
            $modelo = Modelo::find($laudo_ecf->modelo_id);
            array_push($an_marca, $marca);
            array_push($an_modelo, $modelo);
        }

        $laudo_ecfs = LaudosRelacaoEcfs::where('laudo_id', $id)->get();
        $re_marca = [];
        $re_modelo = [];
        foreach ($laudo_ecfs as $laudo_ecf) {
            $marca = Marca::find($laudo_ecf->marca_id);
            $modelo = Modelo::find($laudo_ecf->modelo_id);
            array_push($re_marca, $marca);
            array_push($re_modelo, $modelo);
        }

        return view('laudo.show', [
            'laudo' => $laudo, 'ecfs' => $ecfs, 'ecf_analise_marca' => $ecf_analise_marca, 'ecf_analise_modelo' => $ecf_analise_modelo,
            'relacao_ecfs_marca' => $relacao_ecfs_marca, 'relacao_ecfs_modelo' => $relacao_ecfs_modelo,
            'an_marca' => $an_marca, 'an_modelo' => $an_modelo, 're_marca' => $re_marca, 're_modelo' => $re_modelo
        ]);
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
            $laudo->relacao_ecfs_marca == $request->input('relacao_ecfs_marca') &&
            $laudo->relacao_ecfs_modelo == $request->input('relacao_ecfs_modelo') &&
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
            $laudo->relacao_ecfs_marca = $request->input('relacao_ecfs_marca');
            $laudo->relacao_ecfs_modelo = $request->input('relacao_ecfs_modelo');
            $laudo->comentarios = $request->input('comentarios');
            $laudo->responsavel_testes = $request->input('responsavel_testes');

            $laudo->save();

            $ecf_analise_marca = array();
            $ecf_analise_modelo = array();
            $relacao_ecfs_marca = array();
            $relacao_ecfs_modelo = array();

            foreach ($request->an_marca as $marca) {
                //append to array
                array_push($ecf_analise_marca, Marca::where('nome', $marca)->first()->id);
            }

            foreach ($request->an_modelo as $modelo) {
                //append to array
                array_push($ecf_analise_modelo, Modelo::where('nome', $modelo)->first()->id);
            }

            foreach ($request->re_marca as $marca) {
                //append to array
                array_push($relacao_ecfs_marca, Marca::where('nome', $marca)->first()->id);
            }

            foreach ($request->re_modelo as $modelo) {
                //append to array
                array_push($relacao_ecfs_modelo, Modelo::where('nome', $modelo)->first()->id);
            }

            //remove existing lines with laudo_id from laudo_ecf and laudo_relacao_ecf
            LaudosEcfs::where('laudo_id', $id)->delete();
            LaudosRelacaoEcfs::where('laudo_id', $id)->delete();

            //create new laudos_ecfs with arrays ecf_analise_marca and ecf_analise_modelo and laudo id
            foreach ($ecf_analise_marca as $index => $marca) {
                $laudo_ecf = new LaudosEcfs;
                $laudo_ecf->laudo_id = $laudo->id;
                $laudo_ecf->marca_id = $marca;
                $laudo_ecf->modelo_id = $ecf_analise_modelo[$index];
                $laudo_ecf->save();
            }

            //create new laudos_relacao_ecfs with arrays relacao_ecfs_marca and relacao_ecfs_modelo and laudo id
            foreach ($relacao_ecfs_marca as $index => $marca) {
                $laudo_relacao_ecf = new LaudosRelacaoEcfs;
                $laudo_relacao_ecf->laudo_id = $laudo->id;
                $laudo_relacao_ecf->marca_id = $marca;
                $laudo_relacao_ecf->modelo_id = $relacao_ecfs_modelo[$index];
                $laudo_relacao_ecf->save();
            }

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
        $ecfAnalise = LaudosEcfs::where('laudo_id', $id)->get();
        $relacaoEcfs = LaudosRelacaoEcfs::where('laudo_id', $id)->get();

        foreach ($ecfAnalise as $laudo) {
            $laudo->delete();
        }
        foreach ($relacaoEcfs as $laudo) {
            $laudo->delete();
        }

        $laudo->delete();

        return redirect()->route('laudo.index')->with('msgerro', 'Laudo Excluído com Sucesso!!');
    }

    /**
     * Função que seria responsável por fazer upload dos arquivos, lê-los e preencher os <select> da view.
     * AINDA NÃO FUNCIONA!
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
        } else if ($mes == 2) {
            $mes = "Fevereiro";
        } else if ($mes == 3) {
            $mes = "Março";
        } else if ($mes == 4) {
            $mes = "Abril";
        } else if ($mes == 5) {
            $mes = "Maio";
        } else if ($mes == 6) {
            $mes = "Junho";
        } else if ($mes == 7) {
            $mes = "Julho";
        } else if ($mes == 8) {
            $mes = "Agosto";
        } else if ($mes == 9) {
            $mes = "Setembro";
        } else if ($mes == 10) {
            $mes = "Outubro";
        } else if ($mes == 11) {
            $mes = "Novembro";
        } else if ($mes == 12) {
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

            'txtSGRazaoSocialCnpj' => $empresa->razao_social . " - " . $empresa->cnpj,
            'txtSGNomeSistema' => $laudo->executavel_sgbd,
            'txtSGRequisitoExecutado' => $laudo->requisitos_executados_sgbd,

            'txtSPRazaoSocialCnpj' => $empresa->razao_social . " - " . $empresa->cnpj,
            'txtSPNomeSistema' => $laudo->executavel_sped,
            'txtSPFuncao' => $laudo->funcao_sped,

            'txtSNRazaoSocialCnpj' => $empresa->razao_social . " - " . $empresa->cnpj,
            'txtSNNomeSistema' => $laudo->executavel_nfe,

            'txtEcfMarca' => $laudo->ecf_analise_marca,
            'txtEcfModelo' => $laudo->ecf_analise_modelo,
            'txtObservacaoOTC' => $laudo->comentarios,
            'txtPrincipalExec' => $pdv->nome_principal_executavel,
            'txtRelacaoMarcas' => $laudo->relacao_ecfs_marca,
            'txtRelacaoModelos' => $laudo->relacao_ecfs_modelo,

            //pretendo pegar o sysdate
            'txtDataVersao' => $laudo->data_termino,

            //informações do PDV
            'txtNomeComercial' => $pdv->nome_comercial,
            'txtVersao' => $pdv->versao,
            'txtLinguagemProgramacao' => $pdv->linguagem,
            'txtSo' => $pdv->sistema_operacional,
            'txtBd' => $pdv->data_base,
            'txtPerfilR' => "▢ Perfil R",
            'txtPerfilS' => "▢ Perfil S",
            'txtPerfilT' => "▢ Perfil T",
            'txtPerfilU' => "▢ Perfil U",
            'txtPerfilV' => "▢ Perfil V",
            'txtPerfilW' => "▢ Perfil W",
            'txtPerfilY' => "▢ Perfil Y",
            'txtPerfilZ' => "▢ Perfil Z",

            '$txtDesenvComercializavel' => "▢ Comercializável",
            'txtProprio' => "▢ Exclusivamente Próprio",
            'txtTerceirizado' => "▢ Exclusivamente Terceirizado",

            'txtConcomitante' => "▢ Concomitante",
            'txtNaoConcomitanteDAV' => "▢ Não Concomitante com impressão de DAV",
            'txtNaoConcomitantePV' => "▢ Não Concomitante com com controle de pré-venda",
            'txtNaoConcomitanteCliente' => "▢ Não Concomitante com com controle de conta de cliente",

            'txtDAVSemImpressao' => "▢ DAV - emitido sem impossibilidade de impressão",
            'txtDAVImpressoNF' => "▢ DAV - impresso em impressora não fiscal",
            'txtDAVECF' => "▢ DAV - impresso em ECF",

            'txtStandAlone' => "▢ Exclusivamente Stand Alone",
            'txtRede' => "▢ Em Rede",
            'txtParametrizavel' => "▢ Parametrizável",

            //Informações Doc
            'txtData' => $data_de_hoje,
        ));

        $stringNomeLaudo = $laudo->ifl;
        $pastaParaSalvar = $stringNomeLaudo;
        if (!file_exists($pastaParaSalvar)) {
            mkdir($pastaParaSalvar, 0755, true);
        }
        $pastaParaSalvar .= '/' . $stringNomeLaudo . '.docx';
        $laudo->caminho_laudo = 'public\ModeloLaudoPAFECF.docx' . $pastaParaSalvar;
        $templateProcessor->saveAs($pastaParaSalvar);
        $link = '/' . $laudo->ifl . '/' . $laudo->ifl . '.docx';
        $laudo->save();
        return view('laudo.gerarDocs', ['laudo' => $laudo, 'pdv' => $pdv, 'empresa' => $empresa, 'link' => $link]);
    }

    public function gerarXML($id)
    {
        //chamando o laudo, empresa, pdv e ecfs
        $laudo = Laudo::find($id);
        $pdv = PDV::find($laudo->id_pdv);
        $ecfsAnalise = LaudosEcfs::all();
        $ecfsRelacao = LaudosRelacaoEcfs::all();
        $empresa = Empresa::find($pdv->empresa->id);

        //instância do documento
        $dom = new DOMDocument('1.0', 'UTF-8');
        //formatação do código
        $dom->formatOutput = true;

        $idLaudoValue = $dom->createTextNode($id);
        $idLaudo = $dom->createElement('LaudoId');
        $idLaudo->appendChild($idLaudoValue);

        $iflValue = $dom->createTextNode($laudo->ifl);
        $ifl = $dom->createElement('IFL');
        $ifl->appendChild($iflValue);

        $razaoSocialValue = $dom->createTextNode($empresa->razao_social);
        $razaoSocial = $dom->createElement('RazaoSocial');
        $razaoSocial->appendChild($razaoSocialValue);

        $nomeFantasiaValue = $dom->createTextNode($empresa->nome_fantasia);
        $nomeFantasia = $dom->createElement('NomeFantasia');
        $nomeFantasia->appendChild($nomeFantasiaValue);

        $enderecoValue = $dom->createTextNode($empresa->endereco);
        $endereco = $dom->createElement('Endereço');
        $endereco->appendChild($enderecoValue);

        $bairroValue = $dom->createTextNode($empresa->bairro);
        $bairro = $dom->createElement('Bairro');
        $bairro->appendChild($bairroValue);

        $cidadeValue = $dom->createTextNode($empresa->cidade);
        $cidade = $dom->createElement('Cidade');
        $cidade->appendChild($cidadeValue);

        $ufValue = $dom->createTextNode($empresa->uf);
        $uf = $dom->createElement('UF');
        $uf->appendChild($ufValue);

        $cepValue = $dom->createTextNode($empresa->cep);
        $cep = $dom->createElement('CEP');
        $cep->appendChild($cepValue);

        $telefoneValue = $dom->createTextNode($empresa->telefone);
        $telefone = $dom->createElement('Telefone');
        $telefone->appendChild($telefoneValue);

        $celularValue = $dom->createTextNode($empresa->celular);
        $celular = $dom->createElement('Celular');
        $celular->appendChild($celularValue);

        $cnpjValue = $dom->createTextNode($empresa->cnpj);
        $cnpj = $dom->createElement('CNPJ');
        $cnpj->appendChild($cnpjValue);

        $inscricaoEstadualValue = $dom->createTextNode($empresa->inscricao_estadual);
        $inscricaoEstadual = $dom->createElement('InscricaoEstadual');
        $inscricaoEstadual->appendChild($inscricaoEstadualValue);

        $inscricaoMunicipalValue = $dom->createTextNode($empresa->inscricao_municipal);
        $inscricaoMunicipal = $dom->createElement('InscricaoMunicipal');
        $inscricaoMunicipal->appendChild($inscricaoMunicipalValue);

        $representanteValue = $dom->createTextNode($empresa->representante);
        $representante = $dom->createElement('Representante');
        $representante->appendChild($representanteValue);

        $cpfRepresValue = $dom->createTextNode($empresa->cpf_representante);
        $cpfRepres = $dom->createElement('CPFRepresentante');
        $cpfRepres->appendChild($cpfRepresValue);

        $rgRepresValue = $dom->createTextNode($empresa->rg_representante);
        $rgRepres = $dom->createElement('RGRepresentante');
        $rgRepres->appendChild($rgRepresValue);

        $emailValue = $dom->createTextNode($empresa->email_representante);
        $email = $dom->createElement('Email');
        $email->appendChild($emailValue);

        $responsavelValue = $dom->createTextNode($laudo->responsavel_testes);
        $responsavel = $dom->createElement('ResponsavelTestes');
        $responsavel->appendChild($responsavelValue);
        /////////////////////////////////////////////////////////////////////////////////////
        $identificacaoValue = $dom->createTextNode('IFL – Instituto Filadélfia de Londrina');
        $identificacao = $dom->createElement('Identificacao');
        $identificacao->appendChild($identificacaoValue);

        $homologadorValue = $dom->createTextNode($laudo->homologador);
        $homologador = $dom->createElement('Homologador');
        $homologador->appendChild($homologadorValue);

        $enderecoInstituicaoValue = $dom->createTextNode('Av. Juscelino Kubischeck, 1626');
        $enderecoInstituicao = $dom->createElement('EnderecoInstituicao');
        $enderecoInstituicao->appendChild($enderecoInstituicaoValue);

        $bairroInstituicaoValue = $dom->createTextNode('Centro');
        $bairroInstituicao = $dom->createElement('BairroInstituicao');
        $bairroInstituicao->appendChild($bairroInstituicaoValue);

        $cidadeInstituicaoValue = $dom->createTextNode('Londrina');
        $cidadeInstituicao = $dom->createElement('CidadeInstituicao');
        $cidadeInstituicao->appendChild($cidadeInstituicaoValue);

        $ufInstituicaoValue = $dom->createTextNode('PR');
        $ufInstituicao = $dom->createElement('UFInstituicao');
        $ufInstituicao->appendChild($ufInstituicaoValue);

        $cepInstituicaoValue = $dom->createTextNode('86010-000');
        $cepInstituicao = $dom->createElement('CEPInstituicao');
        $cepInstituicao->appendChild($cepInstituicaoValue);

        $cnpjInstituicaoValue = $dom->createTextNode('78.624.202/0001-00');
        $cnpjInstituicao = $dom->createElement('CNPJInstituicao');
        $cnpjInstituicao->appendChild($cnpjInstituicaoValue);

        $dataInicioValue = $dom->createTextNode($laudo->data_inicio);
        $dataInicio = $dom->createElement('DataInicio');
        $dataInicio->appendChild($dataInicioValue);

        $dataTerminoValue = $dom->createTextNode($laudo->data_termino);
        $dataTermino = $dom->createElement('DataTermino');
        $dataTermino->appendChild($dataTerminoValue);
        /////////////////////////////////////////////////////////////////////////////////////
        $nomeComercialValue = $dom->createTextNode($pdv->nome_comercial);
        $nomeComercial = $dom->createElement('NomeComercial');
        $nomeComercial->appendChild($nomeComercialValue);

        $versaoValue = $dom->createTextNode($pdv->versao);
        $versao = $dom->createElement('Versao');
        $versao->appendChild($versaoValue);

        $dataVersaoValue = $dom->createTextNode($laudo->data_termino);
        $dataVersao = $dom->createElement('DataVersao');
        $dataVersao->appendChild($dataVersaoValue);

        $arqExecValue = $dom->createTextNode($pdv->nome_principal_executavel);
        $arqExec = $dom->createElement('ArquivoExecutavel');
        $arqExec->appendChild($arqExecValue);

        $md5ArqExecValue = $dom->createTextNode('');
        $md5ArqExec = $dom->createElement('MD5ArquivoExecutavel');
        $md5ArqExec->appendChild($md5ArqExecValue);

        $listaExecMd5Value = $dom->createTextNode('');
        $listaExecMd5 = $dom->createElement('ListaExecMD5');
        $listaExecMd5->appendChild($listaExecMd5Value);

        $relacaoExecMd5Value = $dom->createTextNode('');
        $relacaoExecMd5 = $dom->createElement('RelacaoExecMD5');
        $relacaoExecMd5->appendChild($relacaoExecMd5Value);

        $relacao2Md5Value = $dom->createTextNode('');
        $relacao2Md5 = $dom->createElement('Relacao2MD5');
        $relacao2Md5->appendChild($relacao2Md5Value);

        $perfisValue = $dom->createTextNode($pdv->perfis);
        $perfis = $dom->createElement('Perfis');
        $perfis->appendChild($perfisValue);

        $envelopeSegurancaValue = $dom->createTextNode($pdv->envelope_seguranca_marca);
        $envelopeSeguranca = $dom->createElement('EnvelopeSeguranca');
        $envelopeSeguranca->appendChild($envelopeSegurancaValue);

        $envelopeModeloValue = $dom->createTextNode($pdv->envelope_seguranca_modelo);
        $envelopeModelo = $dom->createElement('EnvelopeModelo');
        $envelopeModelo->appendChild($envelopeModeloValue);

        $envelopeNumeroValue = $dom->createTextNode($pdv->numero_envelope);
        $envelopeNumero = $dom->createElement('EnvelopeNumero');
        $envelopeNumero->appendChild($envelopeNumeroValue);
        /////////////////////////////////////////////////////////////////////////////////////
        $linguagemValue = $dom->createTextNode($pdv->linguagem);
        $linguagem = $dom->createElement('Linguagem');
        $linguagem->appendChild($linguagemValue);

        $sistemaOperacionalValue = $dom->createTextNode($pdv->sistema_operacional);
        $sistemaOperacional = $dom->createElement('SistemaOperacional');
        $sistemaOperacional->appendChild($sistemaOperacionalValue);

        $dataBaseValue = $dom->createTextNode($pdv->data_base);
        $dataBase = $dom->createElement('DataBase');
        $dataBase->appendChild($dataBaseValue);

        $desenvolvimentoTipoValue = $dom->createTextNode($pdv->tipo_desenvolvimento);
        $desenvolvimentoTipo = $dom->createElement('TipoDesenvolvimento');
        $desenvolvimentoTipo->appendChild($desenvolvimentoTipoValue);

        $formaImpressaoValue = $dom->createTextNode($pdv->forma_impressao);
        $formaImpressao = $dom->createElement('FormaImpressao');
        $formaImpressao->appendChild($formaImpressaoValue);

        $tipoFuncionamentoValue = $dom->createTextNode($pdv->tipo_funcionamento);
        $tipoFuncionamento = $dom->createElement('TipoFuncionamento');
        $tipoFuncionamento->appendChild($tipoFuncionamentoValue);

        $spedValue = $dom->createTextNode($pdv->sped);
        $sped = $dom->createElement('SPED');
        $sped->appendChild($spedValue);

        $nfeValue = $dom->createTextNode($pdv->nfe);
        $nfe = $dom->createElement('NFE');
        $nfe->appendChild($nfeValue);

        $nfceValue = $dom->createTextNode($pdv->nfce);
        $nfce = $dom->createElement('NFCE');
        $nfce->appendChild($nfceValue);

        $interrupcaoValue = $dom->createTextNode($pdv->tratamento_interrupcao);
        $interrupcao = $dom->createElement('TratamentoInterrupcao');
        $interrupcao->appendChild($interrupcaoValue);

        $integracaoPafValue = $dom->createTextNode($pdv->integracao_paf);
        $integracaoPaf = $dom->createElement('IntegracaoPAF');
        $integracaoPaf->appendChild($integracaoPafValue);

        $aplicacoesEspeciaisValue = $dom->createTextNode($pdv->aplicacoes_especiais);
        $aplicacoesEspeciais = $dom->createElement('AplicacoesEspeciais');
        $aplicacoesEspeciais->appendChild($aplicacoesEspeciaisValue);
        /////////////////////////////////////////////////////////////////////////////////////
        $sgbdEmpresaValue = $dom->createTextNode($pdv->razao_social_empresa);
        $sgbdEmpresa = $dom->createElement('SGBDEmpresa');
        $sgbdEmpresa->appendChild($sgbdEmpresaValue);

        $sgbdEmpresaCnpjValue = $dom->createTextNode($empresa->cnpj);
        $sgbdEmpresaCnpj = $dom->createElement('SGBDEmpresaCNPJ');
        $sgbdEmpresaCnpj->appendChild($sgbdEmpresaCnpjValue);

        $sgbdNomeValue = $dom->createTextNode($laudo->executavel_sgbd);
        $sgbdNome = $dom->createElement('SGBDNome');
        $sgbdNome->appendChild($sgbdNomeValue);

        $sgbdRequisitoValue = $dom->createTextNode($laudo->requisitos_executados_sgbd);
        $sgbdRequisito = $dom->createElement('SGBDRequisito');
        $sgbdRequisito->appendChild($sgbdRequisitoValue);

        $sgbdArquivoNomeValue = $dom->createTextNode('');
        $sgbdArquivoNome = $dom->createElement('SGBDArquivoNome');
        $sgbdArquivoNome->appendChild($sgbdArquivoNomeValue);

        $sgbdArquivoMd5Value = $dom->createTextNode('');
        $sgbdArquivoMd5 = $dom->createElement('SGBDArquivoMD5');
        $sgbdArquivoMd5->appendChild($sgbdArquivoMd5Value);
        /////////////////////////////////////////////////////////////////////////////////////
        $spedEmpresaValue = $dom->createTextNode($pdv->razao_social_empresa);
        $spedEmpresa = $dom->createElement('SPEDEmpresa');
        $spedEmpresa->appendChild($spedEmpresaValue);

        $spedEmpresaCnpjValue = $dom->createTextNode($empresa->cnpj);
        $spedEmpresaCnpj = $dom->createElement('SPEDEmpresaCNPJ');
        $spedEmpresaCnpj->appendChild($spedEmpresaCnpjValue);

        $spedNomeValue = $dom->createTextNode($laudo->executavel_sped);
        $spedNome = $dom->createElement('SPEDNome');
        $spedNome->appendChild($spedNomeValue);

        $spedArquivoNomeValue = $dom->createTextNode('');
        $spedArquivoNome = $dom->createElement('SPEDArquivoNome');
        $spedArquivoNome->appendChild($spedArquivoNomeValue);

        $spedArquivoMd5Value = $dom->createTextNode('');
        $spedArquivoMd5 = $dom->createElement('SPEDArquivoMD5');
        $spedArquivoMd5->appendChild($spedArquivoMd5Value);

        $spedFuncaoValue = $dom->createTextNode($laudo->funcao_sped);
        $spedFuncao = $dom->createElement('SPEDFuncao');
        $spedFuncao->appendChild($spedFuncaoValue);
        /////////////////////////////////////////////////////////////////////////////////////
        $nfeEmpresaValue = $dom->createTextNode($pdv->razao_social_empresa);
        $nfeEmpresa = $dom->createElement('NFEEmpresa');
        $nfeEmpresa->appendChild($nfeEmpresaValue);

        $nfeEmpresaCnpjValue = $dom->createTextNode($empresa->cnpj);
        $nfeEmpresaCnpj = $dom->createElement('NFEEmpresaCNPJ');
        $nfeEmpresaCnpj->appendChild($nfeEmpresaCnpjValue);

        $nfeNomeValue = $dom->createTextNode($laudo->executavel_nfe);
        $nfeNome = $dom->createElement('NFENome');
        $nfeNome->appendChild($nfeNomeValue);

        $nfeArquivoNomeValue = $dom->createTextNode('');
        $nfeArquivoNome = $dom->createElement('NFEArquivoNome');
        $nfeArquivoNome->appendChild($nfeArquivoNomeValue);

        $nfeArquivoMd5Value = $dom->createTextNode('');
        $nfeArquivoMd5 = $dom->createElement('NFEArquivoMD5');
        $nfeArquivoMd5->appendChild($nfeArquivoMd5Value);

        $ecfAnaliseMarcaValue = $dom->createTextNode($laudo->ecf_analise_marca == $ecfsAnalise);
        $ecfAnaliseMarca = $dom->createElement('ECFAnaliseMarca');
        $ecfAnaliseMarca->appendChild($ecfAnaliseMarcaValue);

        $ecfAnaliseModeloValue = $dom->createTextNode($laudo->ecf_analise_modelo == $ecfsAnalise);
        $ecfAnaliseModelo = $dom->createElement('ECFAnaliseModelo');
        $ecfAnaliseModelo->appendChild($ecfAnaliseModeloValue);

        $ecfRelacaoMarcaValue = $dom->createTextNode($laudo->relacao_ecfs_marca == $ecfsRelacao);
        $ecfRelacaoMarca = $dom->createElement('ECFRelacaoMarca');
        $ecfRelacaoMarca->appendChild($ecfRelacaoMarcaValue);

        $ecfRelacaoModeloValue = $dom->createTextNode($laudo->relacao_ecfs_modelo == $ecfsRelacao);
        $ecfRelacaoModelo = $dom->createElement('ECFRelacaoModelo');
        $ecfRelacaoModelo->appendChild($ecfRelacaoModeloValue);

        //-------------------------------------------------------------------------------------
        //criar node
        $laudoNode = $dom->createElement('Laudo');
        $empresaNode = $dom->createElement('Empresa');
        $instituicaoNode = $dom->createElement('Instituicao');
        $pdvNode = $dom->createElement('PDV');
        $pdvCaracteristicasNode = $dom->createElement('CaracteristicasPDV');
        $retaguardaNode = $dom->createElement('Retaguarda');
        $sgbdNode = $dom->createElement('SGBDExecutavel');
        $spedNode = $dom->createElement('SPEDExecutavel');
        $nfeNode = $dom->createElement('NFEExecutavel');
        $ecfNode = $dom->createElement('ECF');
        $ecfAnaliseNode = $dom->createElement('AnaliseECF');
        $ecfRelacaoNode = $dom->createElement('RelacaoECF');
        $naoConformidadeNode = $dom->createElement('NaoConformidades');

        //empresa
        $laudoNode->appendChild($empresaNode);
        $empresaNode->appendChild($idLaudo);
        $empresaNode->appendChild($ifl);
        $empresaNode->appendChild($razaoSocial);
        $empresaNode->appendChild($nomeFantasia);
        $empresaNode->appendChild($endereco);
        $empresaNode->appendChild($bairro);
        $empresaNode->appendChild($cidade);
        $empresaNode->appendChild($uf);
        $empresaNode->appendChild($cep);
        $empresaNode->appendChild($telefone);
        $empresaNode->appendChild($celular);
        $empresaNode->appendChild($cnpj);
        $empresaNode->appendChild($inscricaoEstadual);
        $empresaNode->appendChild($inscricaoMunicipal);
        $empresaNode->appendChild($representante);
        $empresaNode->appendChild($cpfRepres);
        $empresaNode->appendChild($rgRepres);
        $empresaNode->appendChild($email);
        $empresaNode->appendChild($responsavel);
        //instituicao
        $laudoNode->appendChild($instituicaoNode);
        $instituicaoNode->appendChild($identificacao);
        $instituicaoNode->appendChild($homologador);
        $instituicaoNode->appendChild($enderecoInstituicao);
        $instituicaoNode->appendChild($bairroInstituicao);
        $instituicaoNode->appendChild($cidadeInstituicao);
        $instituicaoNode->appendChild($ufInstituicao);
        $instituicaoNode->appendChild($cepInstituicao);
        $instituicaoNode->appendChild($cnpjInstituicao);
        $instituicaoNode->appendChild($dataInicio);
        $instituicaoNode->appendChild($dataTermino);
        //pdv
        $laudoNode->appendChild($pdvNode);
        $pdvNode->appendChild($nomeComercial);
        $pdvNode->appendChild($versao);
        $pdvNode->appendChild($dataVersao);
        $pdvNode->appendChild($arqExec);
        $pdvNode->appendChild($md5ArqExec);
        $pdvNode->appendChild($listaExecMd5);
        $pdvNode->appendChild($relacaoExecMd5);
        $pdvNode->appendChild($relacao2Md5);
        $pdvNode->appendChild($perfis);
        $pdvNode->appendChild($envelopeSeguranca);
        $pdvNode->appendChild($envelopeModelo);
        $pdvNode->appendChild($envelopeNumero);
        //pdv caracteristicas
        $laudoNode->appendChild($pdvCaracteristicasNode);
        $pdvCaracteristicasNode->appendChild($linguagem);
        $pdvCaracteristicasNode->appendChild($sistemaOperacional);
        $pdvCaracteristicasNode->appendChild($dataBase);
        $pdvCaracteristicasNode->appendChild($desenvolvimentoTipo);
        $pdvCaracteristicasNode->appendChild($formaImpressao);
        $pdvCaracteristicasNode->appendChild($tipoFuncionamento);
        $pdvCaracteristicasNode->appendChild($sped);
        $pdvCaracteristicasNode->appendChild($nfe);
        $pdvCaracteristicasNode->appendChild($nfce);
        $pdvCaracteristicasNode->appendChild($interrupcao);
        $pdvCaracteristicasNode->appendChild($integracaoPaf);
        $pdvCaracteristicasNode->appendChild($aplicacoesEspeciais);
        //retaguarda
        $laudoNode->appendChild($retaguardaNode);
        //SGBD
        $retaguardaNode->appendChild($sgbdNode);
        $sgbdNode->appendChild($sgbdEmpresa);
        $sgbdNode->appendChild($sgbdNome);
        $sgbdNode->appendChild($sgbdEmpresaCnpj);
        $sgbdNode->appendChild($sgbdRequisito);
        $sgbdNode->appendChild($sgbdArquivoNome);
        $sgbdNode->appendChild($sgbdArquivoMd5);
        //SPED
        $retaguardaNode->appendChild($spedNode);
        $spedNode->appendChild($spedEmpresa);
        $spedNode->appendChild($spedNome);
        $spedNode->appendChild($spedEmpresaCnpj);
        $spedNode->appendChild($spedFuncao);
        $spedNode->appendChild($spedArquivoNome);
        $spedNode->appendChild($spedArquivoMd5);
        //NFE
        $retaguardaNode->appendChild($nfeNode);
        $nfeNode->appendChild($nfeEmpresa);
        $nfeNode->appendChild($nfeNome);
        $nfeNode->appendChild($nfeEmpresaCnpj);
        $nfeNode->appendChild($nfeArquivoNome);
        $nfeNode->appendChild($nfeArquivoMd5);
        //Ecf
        $laudoNode->appendChild($ecfNode);
        //Analise ECF
        $ecfNode->appendChild($ecfAnaliseNode);
        $ecfAnaliseNode->appendChild($ecfAnaliseMarca); //marca
        $ecfAnaliseNode->appendChild($ecfAnaliseModelo); //modelo
        //Relacao ECF
        $ecfNode->appendChild($ecfRelacaoNode);
        $ecfRelacaoNode->appendChild($ecfRelacaoMarca); //marca
        $ecfRelacaoNode->appendChild($ecfRelacaoModelo); //modelo
        //Nao Conformidades
        $laudoNode->appendChild($naoConformidadeNode);

        //nó principal - root
        $rootNode = $dom->createElement('Laudo');
        $rootNode = $dom->appendChild($laudoNode);
        $dom->appendChild($rootNode);

        //salva o arquivo xml na pasta xml do projeto com o nome do arquivo sendo o id do laudo + .xml
        $dom->save($laudo->ifl . '.xml');

        return view('laudo.gerarDocs', ['laudo' => $laudo, 'pdv' => $pdv, 'empresa' => $empresa]);
    }
}
