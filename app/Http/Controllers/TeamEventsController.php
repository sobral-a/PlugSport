<?php

namespace App\Http\Controllers;


use App\Event;
use App\Team;
use Illuminate\Http\Request;


class TeamEventsController extends Controller
{
    //TODO: Handle the dates when a team is going to be in two different events
    public function all(Request $request) {
        $events = Event::all();
        $user_id = $request->user()->id;
        $teams = Team::where('user_id', '=', $user_id)->get();
        return view('events_coach', compact('events' , 'teams'));
    }

    public function join(Request $request, Event $event) {
        $this->validate($request, [
            'team'         => 'required|integer'
        ]);

          $nb = $event->teams_number;
        //TODO: check only the players (status)
        $count = 0;
        foreach ($event->teams as $team)
        {
            if ($team->pivot->status == 'player')
            {
                $count++;
            }
        }
        if ($count < $nb)
        {
            $team = Team::find($request->team);
            $event->teams()->attach($team);
        }
        //else error
        return back();
    }

    public function removeTeam(Event $event, Team $team)
    {
        $team->events()->detach($event);
        return back();
    }

    public function acceptTeam(Event $event, Team $team)
    {
        //TODO:test si nombre de personnes qui sont dans l'équipe est atteint
        $nb = $event->teams_number;
        //TODO: check only the players (status)
        $count = 0;
        foreach ($event->teams as $t)
        {
            if ($t->pivot->status == 'player')
            {
                $count++;
            }
        }

        if ($count < $nb)
        {
            $team = $event->teams()->where('id', $team->id)->get()->first();
            $team->pivot->status = 'player';
            $team->pivot->save();
        }
        //else error
        return back();
    }

    public function deniedTeam(Event $event, Team $team)
    {
        //test si nombre de personnes est atteint
        //TODO: check only the players (status)
        $team = $event->teams()->where('id', $team->id)->get()->first();
        $team->pivot->status = 'denied';
        $team->pivot->save();
        return back();
    }
}
