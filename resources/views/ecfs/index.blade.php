@extends('layouts.app')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function search() {
                var value = $("#buscarEcf").val().toLowerCase();
                $("#table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            }
        </script>
    </head>
    <div>
        <div style="display: grid; grid-template-columns: 41% 10% 47.3%; gap: 10px" class="grid_pesquisa">
            <input type="text" id="buscarEcf" class="col-md-5" name="buscarEcf" onkeyup="search()"
                placeholder="Digite a marca ou modelo específico..." style="width: 100%" />
            <button id="buttonSearch" type="search" class="btn btn-default">Pesquisar</button>

            <a href="https://sat.sef.sc.gov.br/tax.net/sat.cei.web/ecf/listagem.aspx" class="btn btn-default"
                style="justify-self: end">CEI - Listagem Oficial de ECFs Válidas.</a>
        </div>
    </div>
    <div>
        <h1 style="color: #636b6f;">Listagem de ECF's Válidas</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div>
        <table class="table" id="table" rules="all" style="background-color: white">
            <thead class="headEcfs">
                <tr>
                    <th scope="col" style="text-align: center">Marca da ECF</th>
                    <th scope="col" style="text-align: center">Modelo da ECF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ecfs as $ecf)
                    <tr style="color: #636b6f;">
                        <td scope="col" style="text-align: center">{{ $ecf->marca->nome }}</td>
                        <td scope="col" style="text-align: center">{{ $ecf->nome }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
