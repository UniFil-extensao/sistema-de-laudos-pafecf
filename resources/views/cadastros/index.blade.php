@extends('layouts.app')

@section('content')
    <h1 style="color:#636b6f;">Empresas Cadastradas</h1>
    <form action="/cadastros" method="GET">
        <label for="buscar" style="color:#636b6f">Buscar Empresa</label>
        <div class="form-group col-md-9 input-group">
            <input type="text" id="buscar" class="col-md-10" name="buscar"
                placeholder="Digite a Razão Social da empresa...">
            <span class="input-group-btn col-md-2">
                <button type="submit" class="btn btn-default">Pesquisar</button>
            </span>
        </div>
    </form>
    @if ($buscar)
        <div id="div" class="form-group">
            <a href="/cadastros" class="btn btn-default cold-md-10">Voltar</a>
        </div>
        <h2>Buscando por: {{ $buscar }}</h2>
        @if (count($empresas) > 0)
            @foreach ($empresas as $empresa)
                <div class="well">
                    <h3><a href="/cadastros/{{ $empresa->id }}">{{ $empresa->razao_social }}</a></h3>
                    <p>{{ $empresa->cnpj }}</p>
                    <small>Criado em {{ $empresa->created_at }}</small>
                    <br>
                    <br>
                    <a href="/cadastros/{{ $empresa->id }}">
                        <button type="submit" class="btn btn-default">
                            Editar Cadastro
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-pencil-fill" viewBox="0 0 16 16" style="color: black">
                                <path
                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                            </svg>
                        </button>
                    </a>
                    <a href="/cadastros/{{ $empresa->id }}/PDV">
                        <button type="submit" class="btn btn-default">
                            Cadastro de PDV
                        </button>
                    </a>
                </div>
            @endforeach
            {{ $empresas->links() }}
        @else
            <p>Nenhuma empresa encontrada.</p>
        @endif
    @else
        <a href="/cadastros/create" class="btn btn-default">Cadastrar Nova Empresa</a>
        <br>
        <br>
        @if (count($empresas) > 0)
            @foreach ($empresas as $empresa)
                <div class="well">
                    <h3><a href="/cadastros/{{ $empresa->id }}">{{ $empresa->razao_social }}</a></h3>
                    <p>{{ $empresa->cnpj }}</p>
                    <small>Criado em {{ $empresa->created_at }}</small>
                    <br>
                    <br>
                    <a href="/cadastros/{{ $empresa->id }}">
                        <button type="submit" class="btn btn-default">
                            Editar Cadastro
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-pencil-fill" viewBox="0 0 16 16" style="color: black">
                                <path
                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                            </svg>
                        </button>
                    </a>
                    <a href="/cadastros/{{ $empresa->id }}/PDV">
                        <button type="submit" class="btn btn-default">
                            Cadastro de PDV
                        </button>
                    </a>
                </div>
            @endforeach
            {{ $empresas->links() }}
        @else
            <p>Nenhuma empresa cadastrada</p>
        @endif
    @endif
@endsection
