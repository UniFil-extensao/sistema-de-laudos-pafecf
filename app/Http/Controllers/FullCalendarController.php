<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
    Responsável por inicializar a 'view'
*/

class FullCalendarController extends Controller
{
    public function index(){
        return view('calendar.create');
    }
}
