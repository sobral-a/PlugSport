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

    <div class="panel-group">

        @foreach($teams as $team)
            @foreach($team->events as $event)
                    @if ($availabilities->where('event_id', $event->id)->where('team_id', $team->id)->isNotEmpty())

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapse1">{{ $team->name }} in {{$event->name}}</a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    @foreach($availabilities->where('event_id', $event->id)->where('team_id', $team->id) as $av)
                                        <li>
                                            {{ $av->user->name }}  {{$av->status}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
@endsection
