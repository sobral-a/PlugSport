<?php
use Carbon\Carbon;
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          Dashboard
        </div>
    </div>
</div>
@if(Auth::user()->isAdmin)
    <!-- All events -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Evènements</div>
                    <div class="panel-body">
                        @if (count($events) == 0)
                            <div class="alert alert-info">
                                <strong>Il n'y a actuellement pas d'évènement</strong>
                            </div>
                        @endif
                        <ul class="list-group">
                            @foreach($events as $event)
                                <li class="list-group-item">
                                    <a href="/events/{{ $event->id }}/view">{{ $event->name }}</a>
                                    @if (Auth::id() == $event->user_id ||Auth::user()->isAdmin == 1)
                                        <div class="btn-group pull-right">
                                            <form class="form-horizontal" role="form" method="POST" action="/events/{{ $event->id }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn btn-danger btn-xs">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--All teams -->
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
                                                        Accepter
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
@elseif(Auth::user()->profil == "entraineur")
    <!--Events participating -->

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Les évènements de mes équipes</div>

                    <div class="panel-body">
                        <ul class="list-group">

                            @foreach($teams as $team)
                                @if (count($team->events) > 0)
                                    <a href="/teams/{{ $team->id }}/view">
                                        <button type="submit" class="btn btn-sm">
                                            {{$team->name}}
                                        </button>
                                    </a>

                                    @foreach($team->events as $event)
                                        <li class="list-group-item">
                                            <a href="/events/{{ $event->id }}/view">{{ $event->name }}</a>
                                            @if($event->date < Carbon::today()->toDateString())
                                                <div class="btn-group">
                                                    <button class="btn btn-danger btn-xs">
                                                        Passé
                                                    </button>
                                                </div>
                                            @elseif ($event->pivot->status == 'waiting')
                                                <div class="btn-group">
                                                    <button class="btn btn-warning btn-xs">
                                                        En attente
                                                    </button>
                                                </div>
                                            @elseif($event->pivot->status == 'denied')
                                                <div class="btn-group">
                                                    <button class="btn btn-warning btn-xs">
                                                        Refusé
                                                    </button>
                                                </div>
                                            @elseif ($event->pivot->status == 'player')
                                                <div class="btn-group pull-right">
                                                    @if (count($availabilities->where('event_id', $event->id)->where('team_id', $team->id)) == 0)
                                                        <form class="form-horizontal" role="form" method="POST" action="/availability/{{ $team->id }}/{{ $event->id }}">
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn btn-success btn-xs">
                                                                Vérifier les disponibilités de l'équipe
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button type="submit" class="btn btn btn-warning btn-xs">
                                                            Vérification des disponibilités de l'équipe demandée
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        <strong>Pas d'évènement pour l'équipe: </strong> <a href="/teams/{{ $team->id }}/view"><button type="button" class="btn btn-default btn-xs">{{$team->name}}</button></a>
                                    </div>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teams of the coach -->
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

                                    @if ($team->sport->number == count($team->players->where('pivot.status', 'player')))
                                        <div class="btn-group pull-right">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Equipe pleine
                                            </button>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@elseif(Auth::user()->profil == "joueur")
    <!-- Event participating -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Mes évènements</div>

                    <div class="panel-body">
                        @if (count($events) == 0)
                            <div class="alert alert-info">
                                <strong>Vous n'avez aucun événement de prévu</strong>
                            </div>
                        @endif
                        <ul class="list-group">
                            @foreach($events as $event)
                                <li class="list-group-item">
                                    <a href="/events/{{ $event->id }}/view">{{ $event->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Les équipes où j'ai candidaté</div>

                    <div class="panel-body">
                        @if (count($inTeams) == 0)
                            <div class="alert alert-info">
                                <strong>Vous n'avez candidaté dans aucune équipe</strong>
                            </div>
                        @else
                            <ul class="list-group">
                                @foreach($inTeams as $team)
                                    <li class="list-group-item">
                                        <a href="/teams/{{ $team->id }}/view">{{ $team->name }}</a>
                                        @if (!$team->banned)
                                            <div class="btn-group pull-right">
                                                @if ($team->pivot->status == 'waiting')
                                                    <button type="button" class="btn btn-info btn-xs">En attente</button>
                                                @else
                                                    @if ($team->pivot->status == 'denied')
                                                        <button type="button" class="btn btn-danger btn-xs">Refusé</button>
                                                    @else
                                                        <button type="button" class="btn btn-success btn-xs">Accepté</button>
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
@endsection
