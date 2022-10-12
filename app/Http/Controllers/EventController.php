<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

/**
 * Classe de controle dos Eventos
 * @author Pedro Rocha
 * @version 2.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */

class EventController extends Controller
{
    /**
     * Função responsável por carregar os eventos.
     * @return json - receber todos os eventos do banco.
     */

    public function loadEvents()
    {
        $events = Event::all();

        return response()->json($events);
    }

    /**
     * Função responsável por criar os eventos.
     * @return json - valida o cadastro do evento
     */

    public function store(Request $request)
    {
        Event::create($request->all());

        return response()->json(true);
    }

    /**
     * Função responsável por editar os eventos.
     * @return json - valida a edição do evento
     */

    public function update(Request $request)
    {
        $event = Event::where('id', $request->id)->first();
        $event->fill($request->all());
        $event->save();

        return response()->json(true);
    }

    /**
     * Função responsável por deletar os eventos.
     * @return json - valida o delete do evento.
     */

    public function destroy(Request $request)
    {
        Event::where('id', $request->id)->delete(); //pesquisa pelo id no Event, passado no request,
        //é comparado com id e depois deletado.
        return response()->json(true);
    }
}
