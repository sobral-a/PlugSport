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
            <div class="panel panel-default">
                <div class="panel-heading">Sports disponibles</div>

                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($sports as $sport)
                            <li class="list-group-item">
                                {{ $sport->name }}
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
                                <label for="name" class="control-label">Nom</label>
                                <input type="text"  class="form-control" name="name" value="{{ old('name') }}" required autofocus>
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
@endsection
