<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\PDV;
use App\Http\Requests\StorePDVRequest;
use App\Models\Laudo;

/**
 * Classe de controle dos PDVs.
 * @author Leonardo Lima
 * @version 1.0
 * @copyright NPI © 2021, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class PDVController extends Controller
{
    /**
     * Função responsável por limitar as funções dessa classe somente para usuários logados.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $pdv = PDV::find($id);
        $empresa = Empresa::find($pdv->id_empresa);
        $aplicacoes = explode(", ", $pdv->aplicacoes_especiais);
        $forma_impressao = explode(", ", $pdv->forma_impressao);
        $perfis = explode(", ", $pdv->perfis);
        return view('cadastros.PDV.show', ['empresa' => $empresa, 'pdv'=> $pdv, 'aplicacoes' => $aplicacoes, 'forma_impressao' => $forma_impressao, 'perfis' => $perfis]);
    }

    /**
     * Função responsável por chamar o formulário de cadastro de PDVs da empresa.
     * @param $id - identificador da empresa que receberá o cadastro do PDV.
     * @return view - Formulário de cadastro de PDVs.
     */
    public function create($id){
        $empresa = Empresa::find($id);
        $pdvs = PDV::where([
            ['id_empresa', $id],
            ['validacao', true]
        ])->get();
        return view('cadastros.PDV.create', ['empresa' => $empresa, 'pdvs'=> $pdvs]);
    }

    /**
     * Função responsável por escrever as informações cadastradas no banco de dados.
     * @param \Requests\StorePDVRequest $request - Objeto com todas as informações preenchidas no formulário. Os campos são validados pela classe StorePDVRequest.
     * @return view - Volta para a página inicial do cadastro de PDVs com uma mensagem de êxito.
     */
    public function store(StorePDVRequest $request, $id_empresa){

        $pdv = new PDV;

        $empresa = Empresa::find($id_empresa);

        $pdv->id_empresa = $empresa->id;
        $pdv->razao_social_empresa = $empresa->razao_social;
        $pdv->nome_comercial = $request->nome_comercial;
        $pdv->versao = $request->versao;
        $pdv->nome_principal_executavel = $request->nome_principal_executavel;
        $pdv->linguagem = $request->linguagem;
        $pdv->sistema_operacional = $request->sistema_operacional;
        $pdv->data_base = $request->data_base;
        $pdv->tipo_desenvolvimento = $request->tipo_desenvolvimento;
        $pdv->tipo_funcionamento = $request->tipo_funcionamento;
        $pdv->nfe = $request->nfe;
        $pdv->sped = $request->sped;
        $pdv->nfce = $request->nfce;
        $pdv->tratamento_interrupcao = $request->tratamento_interrupcao;
        $pdv->integracao_paf = $request->integracao_paf;


        $pdv->aplicacoes_especiais = implode(", ", $request->aplicacoes_especiais);
        $pdv->forma_impressao = implode(", ", $request->forma_impressao);
        $pdv->perfis = implode(", ", $request->perfis);

        $pdv->validacao = true;

        $pdv->save();
        return redirect()->back()->with('msg', 'PDV Cadastrado com Sucesso!!');
    }

    /**
     * Atualiza o cadastro do PDV.
     * @param \Requests\StorePDVRequest $request - Objeto com todas as informações preenchidas no formulário. Os campos são validados pela classe StorePDVRequest.
     * @return view - Retorna para a mesma página com a mensagem de êxito ou de erro.
     */
    public function update(StorePDVRequest $request, $id)
    {
        $pdv = PDV::find($id);
        $laudos = Laudo::where('id_pdv', $id)->get();
        $request->aplicacoes_especiais = implode(", ", $request->aplicacoes_especiais);
        $request->forma_impressao = implode(", ", $request->forma_impressao);
        $request->perfis = implode(", ", $request->perfis);
        if (
            $pdv->nome_comercial == $request->input('nome_comercial') &&
            $pdv->versao == $request->input('versao') &&
            $pdv->nome_principal_executavel == $request->input('nome_principal_executavel') &&
            $pdv->linguagem == $request->input('linguagem') &&
            $pdv->sistema_operacional == $request->input('sistema_operacional') &&
            $pdv->data_base == $request->input('data_base') &&
            $pdv->tipo_desenvolvimento == $request->input('tipo_desenvolvimento') &&
            $pdv->tipo_funcionamento == $request->input('tipo_funcionamento') &&
            $pdv->nfe == $request->input('nfe') &&
            $pdv->sped == $request->input('sped') &&
            $pdv->nfce == $request->input('nfce') &&
            $pdv->tratamento_interrupcao == $request->input('tratamento_interrupcao') &&
            $pdv->integracao_paf == $request->input('integracao_paf') &&

            $pdv->aplicacoes_especiais == $request->aplicacoes_especiais &&
            $pdv->executavel_sgbd == $request->input('executavel_sgbd') &&
            $pdv->executavel_sped == $request->input('executavel_sped') &&
            $pdv->executavel_nfe == $request->input('executavel_nfe') &&
            $pdv->forma_impressao == $request->forma_impressao &&
            $pdv->perfis == $request->perfis
        )
        {
            return redirect()->back()->with('msgerro', 'Nenhum campo alterado!!');
        } else {
            $pdv->nome_comercial = $request->input('nome_comercial');
            $pdv->versao = $request->input('versao');
            $pdv->nome_principal_executavel = $request->input('nome_principal_executavel');
            $pdv->linguagem = $request->input('linguagem');
            $pdv->sistema_operacional = $request->input('sistema_operacional');
            $pdv->data_base = $request->input('data_base');
            $pdv->tipo_desenvolvimento = $request->input('tipo_desenvolvimento');
            $pdv->tipo_funcionamento = $request->input('tipo_funcionamento');
            $pdv->nfe = $request->input('nfe');
            $pdv->sped = $request->input('sped');
            $pdv->nfce = $request->input('nfce');
            $pdv->tratamento_interrupcao = $request->input('tratamento_interrupcao');
            $pdv->integracao_paf = $request->input('integracao_paf');
            $pdv->aplicacoes_especiais = $request->aplicacoes_especiais;
            $pdv->executavel_sgbd = $request->input('executavel_sgbd');
            $pdv->executavel_sped = $request->input('executavel_sped');
            $pdv->executavel_nfe = $request->input('executavel_nfe');
            $pdv->forma_impressao = $request->forma_impressao;
            $pdv->perfis = $request->perfis;

            if($laudos){
                foreach ($laudos as $laudo) {
                    $laudo->nome_comercial_pdv = $request->input('nome_comercial');
                    $laudo->save();
                }
            }

            $pdv->save();
            return redirect()->back()->with('msg', 'Cadastro do PDV Editado com Sucesso!!');
        }
    }

    /**
     * Função responsável por esconder da visualização do usuário o cadastro do PDV.
     * @param Integer $id - identificador da empresa
     * @return view - Volta para a página inicial do cadastro de PDV com uma mensagem de êxito.
     */
    public function destroy($id)
    {
        $pdv = PDV::find($id);
        $empresa = Empresa::find($pdv->id_empresa);
        $empresa_id = $empresa->id;
        $pdv->validacao = false;
        $pdv->save();
        return redirect()->route('cadastroPDV.create', ['empresa' => $empresa_id])->with('msgerro', 'PDV Excluído com Sucesso!!');
    }
}
