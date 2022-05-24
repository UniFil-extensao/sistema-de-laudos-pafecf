<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ config('app.name', 'LSAPP') }}</title>
</head>

<body>
    @include('inc.navbar')
    <div class="container">
        <main>
            <div class="container-fluid">
                <div class="row">
                    @if (session('msg'))
                        <p class="msg"
                            style="background-color: #D3EDDA; color: green; border: 1px solid #C3E6CB; width: 100%; margin-bottom: 0; text-align: center; padding: 10px; font-size: large">
                            {{ session('msg') }}</p>
                    @else
                        @if (session('msgerro'))
                            <p class="msgerro"
                                style="background-color: #f59191; color: red; border: 1px solid #C3E6CB; width: 100%; margin-bottom: 0; text-align: center; padding: 10px; font-size: large">
                                {{ session('msgerro') }}</p>
                        @endif
                    @endif
                    @yield('content')
                </div>
            </div>
        </main>
</body>
<br>
<br>
<footer>
    <div class="text-center">
        ©2021 Copyright By Leonardo Lima e Pedro Rocha <br>
        From NPI - Núcleo de Práticas em Informática <br>
        Centro Universitário Filadélfia - UNIFIL
    </div>
</footer>

</html>
