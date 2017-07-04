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

    @if (Auth::user()->profil == 'joueur')
        <div class="container">
            <div class="panel-group">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Demandes de disponibilité <strong>en attente</strong></div>

                                <div class="panel-body">
                                    @if (count($availabilities->where('status', 'waiting')) == 0)
                                        <div class="alert alert-info alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Aucun des entraineurs des équipes où vous êtes présents n'a fait de demande</strong>
                                        </div>
                                    @endif
                                    <ul class="list-group">
                                        @foreach($availabilities->where('status', 'waiting') as $av)
                                            @if($av->event->date >= Carbon::today()->toDateString())
                                            <li class="list-group-item">
                                                <button type="button" class="btn btn-primary btn-xs">
                                                    {{ $av->team->name }}
                                                </button>
                                                @if (!$av->team->banned)
                                                     - Êtes-vous disponible pour l'evènement <a href="/events/{{ $av->event->id }}/view">{{ $av->event->name }}</a> qui aura lieu <?php \Carbon\Carbon::setLocale('fr'); ?>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $av->event->date)->diffForHumans() }} ?
                                                    <div class="btn-group pull-right">
                                                        <form class="form-horizontal" role="form" method="POST" action="/availability/{{ $av->id }}/av">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn btn-success btn-xs">
                                                                Oui
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="btn-group pull-right">
                                                        <form class="form-horizontal" role="form" method="POST" action="/availability/{{ $av->id }}/unav">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn btn-danger btn-xs">
                                                                Non
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning alert-dismissable">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        L'équipe a été bannie, vous ne pouvez donc pas accèder aux demandes de disponibilités.
                                                    </div>
                                                @endif
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="panel-group">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-success">
                            <div class="panel-heading">Demandes de disponibilité <strong>acceptées</strong></div>

                            <div class="panel-body">
                                @if (count($availabilities->where('status', 'available')) == 0)
                                    <div class="alert alert-info alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Aucune demande accéptée</strong>
                                    </div>
                                @endif
                                <ul class="list-group">
                                    @foreach($availabilities->where('status', 'available') as $av)
                                        <li class="list-group-item">
                                            <button type="button" class="btn btn-primary btn-xs">
                                                {{ $av->team->name }}
                                            </button>
                                            @if (!$av->team->banned)
                                                -  <a href="/events/{{ $av->event->id }}/view">{{ $av->event->name }}</a> qui aura lieu <?php \Carbon\Carbon::setLocale('fr'); ?>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $av->event->date)->diffForHumans() }}
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/availability/{{ $av->id }}/unav">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn btn-danger btn-xs">
                                                            Refuser
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="alert alert-warning alert-dismissable">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    L'équipe a été bannie, vous ne pouvez donc pas accèder aux disponibilités acceptées.
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
        </div>

        <div class="container">
            <div class="panel-group">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-warning">
                            <div class="panel-heading">Demandes de disponibilité <strong>refusées</strong></div>

                            <div class="panel-body">
                                @if (count($availabilities->where('status', 'unavailable')) == 0)
                                    <div class="alert alert-info alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Aucune demande refusée</strong>
                                    </div>
                                @endif
                                <ul class="list-group">
                                    @foreach($availabilities->where('status', 'unavailable') as $av)
                                        <li class="list-group-item">
                                            <button type="button" class="btn btn-primary btn-xs">
                                                {{ $av->team->name }}
                                            </button>
                                            @if (!$av->team->banned)
                                                -  <a href="/events/{{ $av->event->id }}/view">{{ $av->event->name }}</a> qui aura lieu <?php \Carbon\Carbon::setLocale('fr'); ?>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $av->event->date)->diffForHumans() }}
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/availability/{{ $av->id }}/av">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn btn-success btn-xs">
                                                            Accepter
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="alert alert-warning alert-dismissable">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    L'équipe a été bannie, vous ne pouvez donc pas accèder aux disponibilités refusées.
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
        </div>
        <div class="container">
            <div class="panel-group">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-warning">
                            <div class="panel-heading">Demandes de disponibilité <strong>passées</strong></div>

                            <div class="panel-body">
                                @if (count($availabilities->where('event.date', '<', Carbon::today()->toDateString())) == 0)
                                    <div class="alert alert-info alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Aucune demande passée à afficher</strong>
                                    </div>
                                @endif
                                <ul class="list-group">
                                    @foreach($availabilities->where('event.date', '<', Carbon::today()->toDateString()) as $av)
                                        <li class="list-group-item">
                                            <button type="button" class="btn btn-primary btn-xs">
                                                {{ $av->team->name }}
                                            </button>
                                                -  <a href="/events/{{ $av->event->id }}/view">{{ $av->event->name }}</a> qui a eu lieu <?php \Carbon\Carbon::setLocale('fr'); ?>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $av->event->date)->diffForHumans() }}
                                                <div class="btn-group pull-right">
                                                    <form class="form-horizontal" role="form" method="POST" action="/availability/{{ $av->id }}/delete">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn btn-danger btn-xs">
                                                            Enlever
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
        </div>
    @endif
@endsection
