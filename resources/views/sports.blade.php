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
                <div class="panel-heading">Sports disponibles</div>

                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($sports as $sport)
                            <li class="list-group-item">
                                {{ $sport->name }}
                                @if($sport->number == 0 || $sport->number == 1 )
                                    <button class="btn btn-xs" type="button">
                                        <span class="badge">{{ $sport->number }}</span>  joueur par équipe
                                    </button>
                                @else
                                    <button class="btn btn-xs" type="button">
                                        <span class="badge">{{ $sport->number }}</span>  joueurs par équipe
                                    </button>
                                @endif
                                <div class="btn-group pull-right">
                                    <form class="form-horizontal" role="form" method="POST" action="/sports/{{ $sport->id }}">
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
                <div class="panel-heading">Ajouter un sport</div>

                <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/sports">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nom</label>
                                <div class="col-md-6">
                                    <input type="text"  class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="number" class="col-md-4 control-label"># joueurs</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="number" step="1" value="0" min="0" max="20" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-4">
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
@endsection
