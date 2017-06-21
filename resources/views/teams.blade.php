@extends('layouts.app')

@section('content')

    <div class="container">
        @if (count($errors))
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    @if (Auth::user()->profil == "entraineur" || Auth::user()->isAdmin)
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mes équipes</div>

                        <div class="panel-body">
                            @if (count($teams) == 0)
                                <div class="alert alert-info">
                                    <strong>Vous n'avez pas créé d'équipe</strong>
                                </div>
                            @endif
                            <ul class="list-group">
                                @foreach($teams as $team)
                                    <li class="list-group-item">
                                        <a href="/teams/{{ $team->id }}/view">{{ $team->name }}</a>
                                        <div class="btn-group pull-right">
                                            <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn btn-danger btn-xs">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                        @if (Auth::user()->isAdmin)
                                            @if (!$team->banned)
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}/ban">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-warning btn-xs">
                                                            Bannir
                                                        </button>
                                                    </form>
                                                </div>
                                             @else
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-warning btn-xs">Banned</button>
                                                </div>
                                                @if (Auth::user()->isAdmin)
                                                    <div class="btn-group pull-right">
                                                        <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn-success btn-xs">
                                                                Allow
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(Auth::user()->isAdmin || Auth::user()->profil == "entraineur")
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Equipes</div>

                        <div class="panel-body">
                            <ul class="list-group">
                                @if (count($allTeams) == 0)
                                    <div class="alert alert-info">
                                        <strong>Il n'y a plus d'autres équipes pour l'instant</strong>
                                    </div>
                                @endif
                                @foreach($allTeams as $team)
                                    <li class="list-group-item">
                                        <a href="/teams/{{ $team->id }}/view">{{ $team->name }}</a>
                                        @if (Auth::user()->isAdmin)
                                            <div class="btn-group pull-right">
                                                <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn btn-danger btn-xs">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                            @if (!$team->banned)
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}/ban">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-warning btn-xs">
                                                            Bannir
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-warning btn-xs">Banned</button>
                                                </div>
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-success btn-xs">
                                                            Allow
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                         @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(Auth::user()->profil == "entraineur" || Auth::user()->isAdmin)
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Créer une équipe</div>

                        <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="/teams/{{ Auth::id() }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name" class="control-label">Nom</label>
                                        <input type="text"  class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="sport" class="control-label">Sport</label>
                                        <select class="form-control" id="sport" name="sport" value="{{ old('sport') }}" required autofocus>
                                            @foreach($sports as $sport)
                                                <option value="{{ $sport->id }}" > {{ $sport->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            Créer
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
