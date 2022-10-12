@extends('layouts.app')

@section('content')
    <h1>Laudos</h1>
    <form action="/laudo" method="GET">
        <label for="buscar">Buscar Laudo</label>
        <div class="form-group col-md-9 input-group">
            <input type="text" id="buscar" class="col-md-10" name="buscar" placeholder="Digite o nome da Empresa...">
            <span class="input-group-btn col-md-2">
                <button type="submit" class="btn btn-default">Pesquisar</button>
            </span>
        </div>
    </form>
    @if ($buscar)
        <div id="div" class="form-group">
            <a href="/laudo" class="btn btn-default cold-md-10">Voltar</a>
        </div>
        <h2>Buscando por: {{ $buscar }}</h2>
        @if (count($laudos) > 0)
            @foreach ($laudos as $laudo)
                <div class="well">
                    <h3><a href="/laudo/{{ $laudo->id }}">{{ $laudo->ifl }} - {{ $laudo->razao_social_empresa }}</a>
                    </h3>
                    <p>PDV: {{ $laudo->nome_comercial_pdv }}</p>
                    <small>Criado em {{ $laudo->created_at }}</small>
                    <br>
                    <br>
                    <a href="/cadastros/{{ $laudo->id }}">
                        <button type="submit" style="color: black">
                            Editar Laudo
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-pencil-fill" viewBox="0 0 16 16" style="color: black">
                                <path
                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                            </svg>
                        </button>
                    </a>
                    <a href="/laudo/{{ $laudo->id }}/gerarDocumentos" class="btn btn-default">
                        <button type="submit">
                            Gerar Documentos
                        </button>
                    </a>
                </div>
            @endforeach
            {{ $laudos->links() }}
        @else
            <p>Nenhum laudo encontrado.</p>
        @endif
    @else
        <a href="/laudo/create" class="btn btn-default">Cadastrar Laudo</a>
        <br>
        <br>
        @if (count($laudos) > 0)
            @foreach ($laudos as $laudo)
                <div class="well">
                    <h3><a href="/laudo/{{ $laudo->id }}">{{ $laudo->ifl }} - {{ $laudo->razao_social_empresa }}</a>
                    </h3>
                    <p>PDV: {{ $laudo->nome_comercial_pdv }}</p>
                    <small>Criado em {{ $laudo->created_at }}</small>
                    <br>
                    <br>
                    <a href="/laudo/{{ $laudo->id }}">
                        <button type="submit" class="btn btn-default">
                            Editar Laudo
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-pencil-fill" viewBox="0 0 16 16" style="color: black">
                                <path
                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                            </svg>
                        </button>
                    </a>
                    <a href="/laudo/{{ $laudo->id }}/gerarDocumentos">
                        <button type="submit" class="btn btn-default">
                            Gerar Documentos
                        </button>
                    </a>
                </div>
            @endforeach
            {{ $laudos->links() }}
        @else
            <p>Nenhuma laudo cadastrado.</p>
        @endif
    @endif
@endsection
