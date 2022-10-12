<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEmpresaRequest;
use App\Models\Empresa;
use App\Models\PDV;
use App\Models\Laudo;
use App\Http\Controllers\LaudoController;

/**
 * Classe de controle das Empresas
 * @author Leonardo Lima
 * @version 1.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class EmpresaController extends Controller
{
    private $objEmpresa;

    /**
     * Função responsável por limitar as funções dessa classe somente para usuários logados.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Função responsável por chamar a view inicial do cadastro de empresa.
     * Se algo for escrito no campo de busca, ela retorna o resultado da busca.
     * @return view - Mostra uma listagem com todas as empresas cadastradas e podemos buscar através da variável $busca
     */
    public function index()
    {
        $buscar = request('buscar');
        if ($buscar) {
            $empresas = Empresa::where([
                ['razao_social', 'LIKE', "%{$buscar}%"],
                ['validacao', true]
            ])->orderBy('id', 'desc')->paginate(10);
            return view('cadastros.index', ['empresas' => $empresas, 'buscar' => $buscar]);
        }
        $empresas = Empresa::where('validacao', true)->orderBy('id', 'desc')->paginate(10);
        return view('cadastros.index', ['empresas' => $empresas, 'buscar' => $buscar]);
    }

    /**
     * Função responsável por chamar o formulário de cadastro de empresa.
     * @return view - Formulário de cadastro
     */
    public function create()
    {
        return view('cadastros.create');
    }

    /**
     * Função responsável por trazer do banco o cadastro da empresa e preencher o formulário para upload.
     * @param Integer $id - identificador da empresa a ser buscado no banco de dados.
     * @return view - Formulário de cadastro da empresa com os campos preenchidos, livres para edição.
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('cadastros.show')->with('empresa', $empresa);
    }

    /**
     * Função responsável por escrever as informações cadastradas no banco de dados
     * @param \Requests\StoreEmpresaRequest $request - Objeto com todas as informações preenchidas no formulário. Os campos são validados pela classe StoreEmpresaRequest.
     * @return view - Volta para a página inicial do cadastro de empresas com uma mensagem de êxito.
     */
    public function store(StoreEmpresaRequest $request)
    {

        $empresa = new Empresa;

        $empresa->razao_social = $request->razao_social;
        $empresa->nome_fantasia = $request->nome_fantasia;
        $empresa->endereco = $request->endereco;
        $empresa->bairro = $request->bairro;
        $empresa->cidade = $request->cidade;
        $empresa->uf = $request->uf;
        $empresa->cep = $request->cep;
        $empresa->telefone = $request->telefone;
        $empresa->celular = $request->celular;
        $empresa->cnpj = $request->cnpj;
        $empresa->inscricao_estadual = $request->inscricao_estadual;
        $empresa->inscricao_municipal = $request->inscricao_municipal;
        $empresa->representante = $request->representante;
        $empresa->cpf_representante = $request->cpf_representante;
        $empresa->rg_representante = $request->rg_representante;
        $empresa->email_representante = $request->email_representante;
        $empresa->validacao = true;

        $empresa->save();

        return redirect('/cadastros')->with('msg', 'Empresa Cadastrada com Sucesso!!');
    }

    /**
     * Função responsável por esconver da visualização do usuário o cadastro da empresa.
     * @param Integer $id - identificador da empresa
     * @return view - Volta para a página inicial do cadastro de empresas com uma mensagem de êxito.
     */
    public function excluirCadastro($id)
    {
        $empresa = Empresa::find($id);
        $empresa->validacao = false;
        $empresa->save();
        return redirect('/cadastros')->with('msgerro', 'Cadastro da Empresa Excluído com Sucesso!!');
    }

    /**
     * Atualiza o cadastro da Empresa
     * @param \Requests\StoreEmpresaRequest $request - Objeto com todas as informações preenchidas no formulário. Os campos são validados pela classe StoreEmpresaRequest.
     * @return view - Retorna para a mesma página com a mensagem de êxito ou de erro.
     */
    public function update(StoreEmpresaRequest $request, $id)
    {
        $empresa = Empresa::find($id);
        $pdvs = PDV::where('id_empresa', $id)->get();
        $laudos = Laudo::where('id_empresa', $id)->get();
        if (
            $empresa->razao_social == $request->input('razao_social') &&
            $empresa->nome_fantasia == $request->input('nome_fantasia') &&
            $empresa->endereco == $request->input('endereco') &&
            $empresa->bairro == $request->input('bairro') &&
            $empresa->cidade == $request->input('cidade') &&
            $empresa->uf == $request->input('uf') &&
            $empresa->cep == $request->input('cep') &&
            $empresa->telefone == $request->input('telefone') &&
            $empresa->celular == $request->input('celular') &&
            $empresa->cnpj == $request->input('cnpj') &&
            $empresa->inscricao_estadual == $request->input('inscricao_estadual') &&
            $empresa->inscricao_municipal == $request->input('inscricao_municipal') &&
            $empresa->representante == $request->input('representante') &&
            $empresa->cpf_representante == $request->input('cpf_representante') &&
            $empresa->rg_representante == $request->input('rg_representante') &&
            $empresa->email_representante == $request->input('email_representante')
        ) {
            return redirect()->back()->with('msgerro', 'Nenhum campo alterado!!');
        } else {
            $empresa->razao_social = $request->input('razao_social');
            $empresa->nome_fantasia = $request->input('nome_fantasia');
            $empresa->endereco = $request->input('endereco');
            $empresa->bairro = $request->input('bairro');
            $empresa->cidade = $request->input('cidade');
            $empresa->uf = $request->input('uf');
            $empresa->cep = $request->input('cep');
            $empresa->telefone = $request->input('telefone');
            $empresa->celular = $request->input('celular');
            $empresa->cnpj = $request->input('cnpj');
            $empresa->inscricao_estadual = $request->input('inscricao_estadual');
            $empresa->inscricao_municipal = $request->input('inscricao_municipal');
            $empresa->representante = $request->input('representante');
            $empresa->cpf_representante = $request->input('cpf_representante');
            $empresa->rg_representante = $request->input('rg_representante');
            $empresa->email_representante = $request->input('email_representante');

            if ($pdvs) {
                foreach ($pdvs as $pdv) {
                    $pdv->razao_social_empresa = $request->input('razao_social');
                    $pdv->save();
                }
            }

            if ($laudos) {
                foreach ($laudos as $laudo) {
                    $laudo->razao_social_empresa = $request->input('razao_social');
                    $laudo->save();
                }
            }

            $empresa->save();
            return redirect()->back()->with('msg', 'Cadastro Editado com Sucesso!!');
        }
    }
}
