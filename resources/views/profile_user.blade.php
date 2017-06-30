@extends('layouts.app')

@section('content')

    @if (count($errors))
        <div class="container alert alert-warning">
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
                        <div class="panel-heading">Configuration des rappels</div>

                        <div class="panel-body">
                            <div class="">
                                <form class="form-vertical" role="form" method="POST" action="/profile/rappel">
                                    {{ csrf_field() }}
                                    Autoriser les mails de rappel du coach
                                    @if(Auth::user()->wantsRappel)
                                        <input type="checkbox" name="notif" value="notif" checked >
                                    @else
                                        <input type="checkbox" name="notif" value="notif">
                                    @endif
                                    <button type="submit" class="btn btn-success btn-xs btn-group pull-right">
                                        Sauvegarder
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
