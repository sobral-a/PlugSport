<?php
use Carbon\Carbon;
?>
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
    @if (Auth::user()->isAdmin)
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
                                        @if (Auth::user()->isAdmin == 1)
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
    @elseif(Auth::user()->profil == "entraineur")
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mes évènements</div>

                        <div class="panel-body">
                            @if (count($events) == 0)
                                <div class="alert alert-info">
                                    <strong>Vous n'avez pas créé d'évènement</strong>
                                </div>
                            @endif
                            <ul class="list-group">
                                @foreach($events as $event)
                                    <li class="list-group-item">
                                        <a href="/events/{{ $event->id }}/view">{{ $event->name }}</a>
                                        <div class="btn-group pull-right">
                                            <form class="form-horizontal" role="form" method="POST" action="/events/{{ $event->id }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn btn-danger btn-xs">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
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
    @endif
    @if(Auth::user()->profil == "entraineur" || Auth::user()->isAdmin)
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Ajouter un évènement sportif</div>

                        <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="/events/{{ Auth::id() }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 control-label">Name</label>
                                        <div class="col-md-6">
                                            <input type="text"  class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="adress" class="col-md-4 control-label">Adresse</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="adress" value="{{ old('adress') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="number" class="col-md-4 control-label"># Teams</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="teams_number" step="1" value="{{ old('teams_number') }}" min="0" max="100" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date" class="col-md-4 control-label">Date</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="2017-07-15" name="date" value="{{ old('date') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sport" class="col-md-4 control-label">Sport</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="sport" name="sport" value="{{ old('sport') }}" required autofocus>
                                                @foreach($sports as $sport)
                                                    <option value="{{ $sport->id }}" > {{ $sport->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-md-4 control-label">Description</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" id="description" name="description" autofocus> {{ old('description') }} </textarea>
                                        </div>
                                    </div>
                                    <<div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Ajouter
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->profil == "joueur")
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

    @endif
@endsection
