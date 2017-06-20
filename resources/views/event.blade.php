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

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
