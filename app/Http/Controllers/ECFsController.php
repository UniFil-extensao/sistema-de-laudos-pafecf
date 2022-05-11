<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Http\Requests\StoreECFRequest;
use App\Models\Ecfs;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Models\Modelo;

/**
 * Classe de controle das ECFs
 * @author Leonardo Lima
 * @version 1.0
 * @copyright NPI © 2021, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class ECFsController extends Controller
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
     * Função responsável por chamar a view inicial do cadastro de ECF.
     * Mostra também o formulário de cadastro de ECFs.
     * @return view - * Mostra todas as ECF's cadastradas numa listagem.
     */
    public function index(){
        $ecfsExistentes = Modelo::all();
        return view('ecfs.index', ['ecfs'=>$ecfsExistentes]);
    }

    /**
     * Função responsável por escrever as informações cadastradas no banco de dados.
     * @param \Requests\StoreECFRequest $request - Objeto com todas as informações preenchidas no formulário. Os campos são validados pela classe StoreECFRequest.
     * @return view - Volta para a mesma página inicial com uma mensagem de êxito do cadastro efetuado.
     */
    public function store(StoreECFRequest $request){
        $ecf = new Ecfs;
        $ecfsExistentes = Ecfs::all();
        foreach ($ecfsExistentes as $ecfAtual) {
            if ($ecfAtual->marca == $request->marca &&
                $ecfAtual->modelo == $request->modelo) {
                    return redirect('/ecfs')->with('msgerro', 'ECF já Cadastrada Anteriormente!!');
            }
        }
        $ecf->marca = $request->marca;
        $ecf->modelo = $request->modelo;

        $ecf->save();
        return redirect('/ecfs')->with('msg', 'ECF cadastrada com Sucesso!!');
    }

}
