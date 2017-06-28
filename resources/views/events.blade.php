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
    @if(Auth::user()->profil == "entraineur")
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
                                {{$team->name}}

                                @foreach($team->events as $event)
                                <li class="list-group-item">
                                    <a href="/events/{{ $event->id }}/view">{{ $event->name }}</a>
                                    @if ($event->pivot->status == 'waiting')
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
                                        @endif
                                </li>
                                @endforeach
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
                        <div class="panel-heading">Ajouter un évènement sportif</div>

                        <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="/events/{{ Auth::id() }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name" class="control-label">Nom</label>
                                        <input type="text"  class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="adress" class="control-label">Adresse</label>
                                        <input type="text" class="form-control" name="adress" value="{{ old('adress') }}" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="number" class="control-label"># Teams</label>
                                        <input type="number" class="form-control" name="teams_number" step="1" value="{{ old('teams_number') }}" min="0" max="100" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="date" class="control-label">Date</label>
                                        <input type="text" class="form-control" placeholder="2017-07-15" name="date" value="{{ old('date') }}" required autofocus>
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
                                        <label for="description" class="control-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" autofocus> {{ old('description') }} </textarea>
                                    </div>
                                    <div class="form-group">
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
