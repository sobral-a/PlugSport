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
    @if (Auth::user()->profil == "joueur")
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Les équipes où j'ai candidaté</div>

                        <div class="panel-body">
                            @if (count($user[0]->inTeams) == 0)
                                <div class="alert alert-info">
                                    <strong>Vous n'avez candidaté dans aucune équipe</strong>
                                </div>
                            @else
                                <ul class="list-group">
                                    @foreach($user[0]->inTeams as $team)
                                        <li class="list-group-item">
                                            <a href="/teams/{{ $team->id }}/view">{{ $team->name }}</a>
                                            @if (!$team->banned)
                                                <div class="btn-group pull-right">
                                                    @if ($team->pivot->status == 'waiting')
                                                        <button type="button" class="btn btn-info btn-xs">Waiting</button>
                                                    @else
                                                        @if ($team->pivot->status == 'denied')
                                                            <button type="button" class="btn btn-danger btn-xs">Denied</button>
                                                        @else
                                                            <button type="button" class="btn btn-success btn-xs">Accepted</button>
                                                        @endif
                                                    @endif
                                                </div>
                                            @else
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-warning btn-xs">Banned</button>
                                                </div>
                                            @endif
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/players/{{ $team->id }}/{{ Auth::id() }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn btn-danger btn-xs">
                                                            Quitter
                                                        </button>
                                                    </form>
                                                </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(Auth::user()->profil == "joueur")
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
                                        @if ($team->banned)
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn btn-warning btn-xs">Banned</button>
                                            </div>
                                        @else
                                            @if ($team->sport->number == count($team->players->where('pivot.status', 'player')))
                                                <div class="btn-group pull-right">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        Equipe pleine
                                                    </button>
                                                </div>
                                            @else
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/players/{{ $team->id }}/{{ Auth::id() }}">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            Candidater
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
@endsection
