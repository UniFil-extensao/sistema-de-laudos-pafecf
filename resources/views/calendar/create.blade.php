<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link href='{{ asset('assets/fullcalendar/css/style.css') }}' rel='stylesheet' />
    <link href='{{ asset('assets/fullcalendar/packages/core/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('assets/fullcalendar/packages/daygrid/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('assets/fullcalendar/packages/timegrid/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('assets/fullcalendar/packages/list/main.css') }}' rel='stylesheet' />

</head>

<nav class="navbar navbar-inverse">

    <div class="container" style="margin-bottom: 10px">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home"><img id="logo" src="{{ url('img\logo.svg') }}"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            @guest
                <ul class="nav navbar-nav">
                    <li><a href="/about">Sobre</a></li>
                    <li><a href="/services">Serviços</a></li>
                </ul>
                <ul class="nav navbar-nav top-right">
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Registro</a></li>
                </ul>
            @else
                <ul class="nav navbar-nav">
                    <li><a href="/home">Home</a></li>
                    <li><a href="/about">Sobre</a></li>
                    <li><a href="/cadastros">Empresas</a></li>
                    <li><a href="/ecfs">Listagem de ECFs</a></li>
                    <li><a href="/laudo">Laudos</a></li>
                    <li><a href="/calendario">Calendário</a></li>
                </ul>
                <ul class="nav navbar-nav top-right">
                    <li><a href="/profile/show">Editar Perfil</a></li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            @endguest
        </div>
    </div>
</nav>

<body>

    @include('calendar.modal-calendar')

    <div id='wrap'>

        <div id='calendar' data-route-load-events="{{ route('routeLoadEvents') }}"
            data-route-event-update="{{ route('routeEventUpdate') }}"
            data-route-event-store="{{ route('routeEventStore') }}"
            data-route-event-delete="{{ route('routeEventDelete') }}"></div>

        <div style='clear:both'></div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script src='{{ asset('assets/fullcalendar/js/script.js') }}'></script>
    <script src='{{ asset('assets/fullcalendar/js/calendar.js') }}'></script>

    <script src='{{ asset('assets/fullcalendar/packages/core/main.js') }}'></script>
    <script src='{{ asset('assets/fullcalendar/packages/interaction/main.js') }}'></script>
    <script src='{{ asset('assets/fullcalendar/packages/daygrid/main.js') }}'></script>
    <script src='{{ asset('assets/fullcalendar/packages/timegrid/main.js') }}'></script>
    <script src='{{ asset('assets/fullcalendar/packages/list/main.js') }}'></script>

    <script src='{{ asset('assets/fullcalendar/packages/core/locales-all.js') }}'></script>

</body>
