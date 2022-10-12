<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Classe de controle da página Home
 * @author Leonardo Lima
 * @version 1.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
