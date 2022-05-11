@extends('layouts.app')
@section('content')

    <a href="https://sat.sef.sc.gov.br/tax.net/sat.cei.web/ecf/listagem.aspx" class="btn btn-default">CEI - Listagem Oficial de ECFs Válidas.</a>
    <h1>Listagem de ECF's Válidas</h1>
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
        {{-- {{ $ecfs }} --}}
        <table class="table" rules="all" border="1">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center">Marca da ECF</th>
                    <th scope="col" style="text-align: center">Modelo da ECF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ecfs as $ecf)
                    <tr>
                        <td scope="col" style="text-align: center">{{ $ecf->marca->nome }}</td>
                        <td scope="col" style="text-align: center">{{ $ecf->nome }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
