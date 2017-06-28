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


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">{{ $event->name }}</div>

                    <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="/events/{{ Auth::id() }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <div class="form-group">
                                    <label for="adress" class="control-label">Adresse</label>
                                    <input type="text" class="form-control" name="adress" readonly="readonly" value="{{ $event->adress }}">
                                </div>
                                <div class="form-group">
                                    <label for="number" class="control-label"># Teams</label>
                                    <input type="number" class="form-control" name="teams_number" readonly="readonly" step="1" value="{{ $event->teams_number }}" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label for="date" class="control-label">Date</label>
                                    <input type="text" class="form-control" placeholder="2017-07-15" name="date" readonly="readonly" value="{{ $event->date }}">
                                </div>
                                <div class="form-group">
                                    <label for="sport" class="control-label">Sport</label>
                                    <select class="form-control" id="sport" name="sport" readonly="readonly" value="{{ $event->sport_id }}">
                                        @foreach($sports as $sport)
                                            <option value="{{ $sport->id }}"
                                                @if ($sport->id == $event->sport_id)
                                                    selected="selected"
                                                @endif
                                            > {{ $sport->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" readonly="readonly"> {{ $event->description }} </textarea>
                                </div>
                                @if (Auth::user()->isAdmin || Auth::id() == $event->user_id )
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">
                                            Supprimer
                                        </button>
                                    </div>
                                @endif
                            </form>
                        @if(Auth::user()->profil == 'entraineur' && !Auth::user()->isAdmin)

                            <div class="btn-group pull-right">
                                <form class="form-vertical" role="form" method="POST" action="/events/join/{{ $event->id }}">
                                    <select class="form-control" id="team" name="team" value="{{ old('team') }}" required autofocus>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}" > {{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-success btn-xs">
                                        Rejoindre
                                    </button>
                                </form>
                            </div>
                        @endif
                        </div>
                    </div>
                @if (Auth::user()->profil == 'entraineur')
                    <div class="panel panel-success">
                        <div class="panel-heading">Equipes participantes</div>
                        <div class="panel-body">
                            <ul>
                                @foreach($event->teams as $team)
                                    @if ($team->pivot->status == 'player')
                                        <li>
                                            {{ $team->name }}
                                            @if(Auth::id() == $event->user_id || Auth::user()->isAdmin )
                                                <form class="form-horizontal btn-group pull-right" role="form" method="POST" action="/events/{{$event->id}}/{{$team->id}}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn btn-danger btn-xs">
                                                        Enlever
                                                    </button>
                                                </form>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                        </div>
                    </div>

                    <div class="panel panel-warning">
                        <div class="panel-heading">Equipes candidates</div>
                        <div class="panel-body">
                            <ul>
                                @foreach($event->teams as $team)
                                    @if ($team->pivot->status == 'denied')
                                        <li>
                                            {{ $team->name }}
                                            @if(Auth::id() == $event->user_id || Auth::user()->isAdmin )
                                            <div class="btn-group pull-right">
                                                <form class="form-horizontal" role="form" method="POST" action="/events/{{$event->id}}/{{$team->id}}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn btn-danger btn-xs">
                                                        Enlever
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </li>
                                    @endif
                                    @if ($team->pivot->status == 'waiting')
                                        <li>
                                            {{ $team->name }}
                                            @if(Auth::id() == $event->user_id || Auth::user()->isAdmin )
                                            <div class="btn-group pull-right">
                                                <form class="form-horizontal" role="form" method="POST" action="/events/{{$event->id}}/{{$team->id}}/denied">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PATCH') }}
                                                    <button type="submit" class="btn btn btn-danger btn-xs">
                                                        Refuser
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="btn-group pull-right">
                                                <form class="form-horizontal" role="form" method="POST" action="/events/{{$event->id}}/{{$team->id}}/accept">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PATCH') }}
                                                    <button type="submit" class="btn btn btn-success btn-xs">
                                                        Accepter
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
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
@endsection
