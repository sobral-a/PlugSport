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
    @if(Auth::user()->profil == 'entraineur' && !Auth::user()->isAdmin)
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Evènements</div>

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