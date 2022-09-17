<style>
    .top-right {
        position: absolute;
        right: 50px;
    }
</style>
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
