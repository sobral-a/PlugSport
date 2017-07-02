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

    @if (Auth::user()->profil == 'entraineur')
        <div class="container">
            <div class="panel-group">
                <div class="row">

                    @foreach($teams as $team)
                        @foreach($team->events as $event)
                                @if ($availabilities->where('event_id', $event->id)->where('team_id', $team->id)->isNotEmpty())

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse1">
                                                <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Equipe: <strong>{{ $team->name }}</strong> pour l'évènement <b>{{ $event->name }}</b>
                                            </a>
                                            @if (!$team->banned)
                                                <div class="btn-group pull-right">
                                                    @if (count($availabilities->where('event_id', $event->id)->where('team_id', $team->id)->where('status', 'available')) == 0)
                                                        <button type="button" class="btn btn-danger btn-xs"><span class="badge">0</span> joueur disponible</button>
                                                    @else
                                                        @if(count($availabilities->where('event_id', $event->id)->where('team_id', $team->id)->where('status', 'available')) ==
                                                         count($availabilities->where('event_id', $event->id)->where('team_id', $team->id)->where('status', 'available')))
                                                            <button type="button" class="btn btn-primary btn-xs">
                                                                Equipe prête
                                                            </button>
                                                        @endif
                                                        <button type="button" class="btn btn-primary btn-xs">
                                                            <span class="badge">
                                                                {{ count($availabilities->where('event_id', $event->id)->where('team_id', $team->id)->where('status', 'available')) }}
                                                            </span>
                                                            <strong> / </strong>
                                                            <span class="badge">
                                                                {{ count($availabilities->where('event_id', $event->id)->where('team_id', $team->id)) }}
                                                            </span>
                                                            joueurs disponibles
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                @if (Auth::user()->isAdmin)
                                                    <div class="btn-group pull-right">
                                                        <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team->id }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn-success btn-xs">
                                                                Autoriser
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-warning btn-xs">Equipe bannie</button>
                                                </div>
                                            @endif
                                        </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            @if (!$team->banned)
                                                <ul class="list-group">
                                                    @foreach($availabilities->where('event_id', $event->id)->where('team_id', $team->id) as $av)
                                                        <li class="list-group-item">
                                                            {{ $av->user->first_name }} {{ $av->user->name }}
                                                            @if ($av->status == 'waiting')
                                                                <button type="button" class="btn btn-info btn-xs">En attente de réponse</button>
                                                            @else
                                                                @if ($av->status == 'unavailable')
                                                                    <button type="button" class="btn btn-danger btn-xs">Indisponible</button>
                                                                @else
                                                                    <button type="button" class="btn btn-success btn-xs">Disponible</button>
                                                                @endif
                                                            @endif
                                                            <form class="form-horizontal btn-group pull-right" role="form" method="POST" action="/players/{{ $team->id }}/{{ $av->user->id }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="submit" class="btn btn btn-danger btn-xs">
                                                                    Enlever de l'équipe
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="alert alert-warning">
                                                    L'équipe a été bannie, vous ne pouvez donc pas accèder aux disponibilités.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>

        </div>

    @endif
@endsection
