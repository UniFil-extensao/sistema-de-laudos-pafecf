<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Classe de controle das páginas - PS: não está sendo utilizada. Foi criada para testes.
 * @author Leonardo Lima
 * @author Pedro Fernando Dalbello Rocha
 * @version 2.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class PagesController extends Controller
{

    public function welcome(){
        $title = 'Welcome to Laravel!!';
        //return view('pages.index', compact('title'));
        return view('pages.welcome')->with('title', $title);
    }

    public function index(){
        $title = 'Welcome to Laravel!!';
        //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function about(){
        $title = 'Sobre Nós';
        return view('pages.about')->with('title', $title);
    }

    public function teste(){
        return view('pages.teste');
    }

    public function services(){
        $data = array(
            'title' => 'Serviços',
            'services' => ['Homologação', 'Pré-homologação', 'Consultoria']
        );
        return view('pages.services')->with($data);
    }

    public function cadastro_empresas(){
        $title = 'Cadastro de Empresas';
        return view('pages.cadastro_empresas')->with('title', $title);
    }

}
