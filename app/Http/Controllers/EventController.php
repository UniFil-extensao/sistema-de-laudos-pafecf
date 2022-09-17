<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /*
    * Carregar os eventos.
    * json -> receber todos os eventos do banco.
    */

    public function loadEvents()
    {
        $events = Event::all();

        return response()->json($events);
    }

    public function store(Request $request)
    {
        Event::create($request->all());

        return response()->json(true);
    }

    public function update(Request $request)
    {
        $event = Event::where('id', $request->id)->first();
        $event->fill($request->all());
        $event->save();

        return response()->json(true);
    }

    public function destroy(Request $request)
    {
        Event::where('id', $request->id)->delete(); //pesquisa pelo id no Event, passado no request,
        //é comparado com id e depois deletado.
        return response()->json(true);
    }
}

// var_dump -> Mostra informações sobre a variável
    //var_dump($request->all());
