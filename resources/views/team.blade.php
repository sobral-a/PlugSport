@extends('layouts.app')

@section('content')

    @if (count($errors))
        <div class="container alert alert-warning alert-dismissible" >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel-group">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            {{ $team->name }}
                            @if (!$team->banned)
                                <div class="btn-group pull-right">
                                    @if (Auth::user()->profil == "joueur")

                                        @if ($inTeam == true)
                                            @if ($team->pivot->status == 'waiting')
                                                <button type="button" class="btn btn-info btn-xs">En attente</button>
                                            @else
                                                @if ($team->pivot->status == 'denied')
                                                    <button type="button" class="btn btn-danger btn-xs">Refusé</button>
                                                @else
                                                    <button type="button" class="btn btn-success btn-xs">Accepté</button>
                                                @endif
                                            @endif
                                        @elseif ($team->sport->number > count($team->players->where('pivot.status', 'player')))
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
                                </div>
                            @else
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-warning btn-xs">Bannie</button>
                                </div>
                                @if (Auth::user()->isAdmin)
                                    <div class="btn-group pull-right">
                                        <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-success btn-xs">
                                                Accepter
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                            @if ($inTeam == true)
                                <div class="btn-group pull-right">
                                    <form class="form-horizontal" role="form" method="POST" action="/players/{{ $team->id }}/{{ Auth::id() }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn btn-danger btn-xs">
                                            Quitter
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if ($team->sport->number == count($team->players->where('pivot.status', 'player')))
                                <div class="btn-group pull-right">
                                    <button type="submit" class="btn btn-primary btn-xs">
                                        Equipe pleine
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="/teams/{{ Auth::id() }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <div class="form-group">
                                    <label for="coach" class="col-md-4 control-label">Entraineur</label>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" name="coach" readonly="readonly" value="{{ $team->user->name }} {{ $team->user->first_name }}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sport" class="col-md-4 control-label">Sport</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="sport" name="sport" readonly="readonly" value="{{ $team->sport->number }}" >
                                            @foreach($sports as $sport)
                                                <option value="{{ $sport->id }}" > {{ $sport->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="number" class="col-md-4 control-label"># Teams</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="teams_number" readonly="readonly" step="1" value="{{ count($team->players->where('pivot.status', 'player')) }} / {{  $team->sport->number }}" min="0" max="100">
                                    </div>
                                </div>
                                @if (Auth::user()->isAdmin || Auth::id() == $team->user->id )
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-danger">
                                            Supprimer
                                        </button>
                                    </div>
                                @endif
                            </form>
                            </div>
                        </div>

                        @if (Auth::user()->isAdmin || Auth::user()->id == $team->user_id)
                            <div class="panel panel-success">
                                <div class="panel-heading">Joueurs de cette équipe</div>
                                <div class="panel-body">
                                    <ul>
                                        @foreach($team->players as $player)
                                            @if ($player->pivot->status == 'player')
                                                <li>
                                                    <a href="/profile/public/{{$player->id}}">{{ $player->first_name }} {{ $player->name }}</a>
                                                    <form class="form-horizontal btn-group pull-right" role="form" method="POST" action="/players/{{ $team->id }}/{{ $player->id }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn btn-danger btn-xs">
                                                            Enlever
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                            <div class="panel panel-warning">
                                <div class="panel-heading">Joueurs candidats</div>
                                <div class="panel-body">
                                    <ul class="list-group">
                                        @foreach($team->players as $player)
                                            @if ($player->pivot->status == 'denied')
                                                <li class="list-group-item">
                                                    <a href="/profile/public/{{$player->id}}">{{ $player->first_name }} {{ $player->name }}</a>
                                                    <div class="btn-group pull-right">
                                                        <form class="form-horizontal" role="form" method="POST" action="/players/{{ $team->id }}/{{ $player->id }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="submit" class="btn btn btn-danger btn-xs">
                                                                Enlever
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endif
                                            @if ($player->pivot->status == 'waiting')
                                                <li class="list-group-item">
                                                    {{ $player->first_name }} {{ $player->name }}
                                                    <div class="btn-group pull-right">
                                                        <form class="form-horizontal" role="form" method="POST" action="/players/{{ $team->id }}/{{ $player->id }}/denied">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn btn-danger btn-xs">
                                                                Refuser
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="btn-group pull-right">
                                                        <form class="form-horizontal" role="form" method="POST" action="/players/{{ $team->id }}/{{ $player->id }}/player">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn btn-success btn-xs">
                                                                Accepter
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button class="btn btn-warning btn-xs">
                                                            En attente
                                                        </button>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
