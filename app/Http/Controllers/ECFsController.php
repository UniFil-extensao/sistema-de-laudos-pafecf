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
 * @author Pedro Fernando Dalbello Rocha
 * @version 2.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
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
     * Função responsável por chamar a view de ECFs cadastradas.
     * @return view - * Mostra todas as ECF's cadastradas numa listagem.
     */
    public function index()
    {
        $ecfsExistentes = Modelo::all();
        return view('ecfs.index', ['ecfs'=>$ecfsExistentes]);
    }

    public function filter()
    {

        if(isset($_POST['buscarEcf'])){
            $search = $_POST['buscarEcf'];
        }

        $filter = Modelo::where('nome','LIKE',"%{$search}%")->get();
        return view('ecfs.index', ['ecfs'=>$filter]);
        /* dd($filter); */
    }
}
