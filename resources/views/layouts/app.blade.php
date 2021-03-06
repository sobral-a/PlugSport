<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PlugSport') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'PlugSport') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Se connecter</a></li>
                            <li><a href="{{ route('register') }}">S'inscrire</a></li>
                        @else
                            @if (Auth::user()->isAdmin)
                                <li><a href="/events">Tous les évènements</a></li>
                                <li><a href="{{ route('sports') }}">Sports</a></li>
                                <li><a href="/events/{{ Auth::id() }}">Évènements</a></li>
                                <li><a href="/teams/{{  Auth::id() }}">Equipes</a></li>
                                <li><a href="/availability">Disponibilités</a></li>
                            @endif
                            @if (Auth::user()->profil == 'joueur')
                                 <li><a href="/events/{{ Auth::id() }}">Mes évènements</a></li>
                                 <li><a href="/teams/{{  Auth::id() }}/player">Equipes</a></li>
                                 <li><a href="/availability/player">Disponibilités</a></li>
                                @endif
                            @if(Auth::user()->profil == 'entraineur' && !Auth::user()->isAdmin)
                                <li><a href="/events">Tous les évènements</a></li>
                                <li><a href="/events/{{ Auth::id() }}">Mes évènements</a></li>
                                <li><a href="/teams/{{  Auth::id() }}">Equipes</a></li>
                                <li><a href="/availability">Disponibilités</a></li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/profile">Profile</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Se déconnecter
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
