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
    @if(Auth::user()->profil == 'entraineur' || Auth::user()->isAdmin)
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Filtre de recherche</div>

                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="/search">
                                {{ csrf_field() }}
                                <div class="form-group">

                                    <label for="sport" class="col-md-4 control-label">Sport</label>
                                    <div class="col-md-6">
                                        <!--Find a way to reuse old, not working right now-->
                                        <select class="form-control" id="sport" name="sport" value="{{ old('sport') }}" required autofocus>
                                            <option value="0" > Tous</option>
                                            @foreach($sports as $sport)
                                                <option value="{{ $sport->id }}" > {{ $sport->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Appliquer filtre
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Résultat(s)</div>

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
