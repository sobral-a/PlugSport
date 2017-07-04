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
                <div class="panel panel-default">
                    <div class="panel-heading">Informations personnels</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/profile/update">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name" class="col-md-4 control-label">Prénom</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" readonly="readonly">

                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nom</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}" readonly="readonly">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sport" class="col-md-4 control-label">Sport</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="sport" name="sport" readonly="readonly">
                                        <option value="0"
                                                @if (!$user->sport_id || $user->sport_id == 0)
                                                selected="selected"
                                                @endif
                                        > Pas de sport préféré</option>
                                        @foreach($sports as $sport)
                                            <option value="{{ $sport->id }}"
                                                    @if ($sport->id == $user->sport_id)
                                                    selected="selected"
                                                    @endif
                                            > {{ $sport->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                  <textarea class="form-control" id="description" name="description"> {{ $user->description }} </textarea>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
