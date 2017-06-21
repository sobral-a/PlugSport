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
                    <div class="panel-heading">
                        {{ $team[0]->name }}
                        @if (Auth::user()->profil == "joueur")
                            <div class="btn-group pull-right">
                                <form class="form-horizontal" role="form" method="POST" action="/teams/{{ $team[0]->id }}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn btn-success btn-xs">
                                        Candidater
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/teams/{{ Auth::id() }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="form-group">
                                <label for="coach" class="control-label">Entraineur</label>
                                <input type="text"  class="form-control" name="coach" readonly="readonly" value="{{ $team[0]->user->name }} {{ $team[0]->user->first_name }}" >
                            </div>
                            <div class="form-group">
                                <label for="sport" class="control-label">Sport</label>
                                <select class="form-control" id="sport" name="sport" readonly="readonly" value="{{ $team[0]->sport->number }}" >
                                    @foreach($sports as $sport)
                                        <option value="{{ $sport->id }}" > {{ $sport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="number" class="control-label"># Players</label>
                                <input type="text" class="form-control" name="teams_number" readonly="readonly" step="1" value="{{ count($team[0]->players) }} / {{  $team[0]->sport->number }}" min="0" max="100">
                            </div>
                            @if (Auth::user()->isAdmin || Auth::id() == $team[0]->user->id )
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">
                                        Supprimer
                                    </button>
                                </div>
                            @endif
                        </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
