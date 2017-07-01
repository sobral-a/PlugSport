<?php

namespace App\Http\Controllers;


use App\Event;
use App\Team;
use App\Sport;
use Illuminate\Http\Request;


class TeamEventsController extends Controller
{
    //TODO: Handle the dates when a team is going to be in two different events
    public function all() {
        $sports = Sport::all();
        $events = Event::all();
        return view('events_coach', compact('events' , 'teams', 'sports'));
    }

    public function filter(Request $request) {

        $this->validate($request, [
            'sport'        => 'required|integer'
        ]);
        $filter = $request->sport;
        if ($filter == 0) {
            $events = Event::all();
        }
        else {
           $events = Event::where('sport_id', $filter)->get();
        }
        $sports = Sport::all();
        return view('events_coach', compact('events' , 'teams', 'sports', 'filter'));
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
            $event_already_happening = $team->events()->whereDate('date', '=', $event->date)->get();
            if ($event_already_happening->count() == 1) {
                 $errors['event_same_date']= 'Cette équipe participe déjà à un événement à cette date là.';
            }
            else {
                $event->teams()->attach($team);
            }
        }
        else
        {
            $errors['full_event']= 'L\'événement est plein, il n\'est plus possible de candidater';
        }
        if (isset($errors))
            return back()->withErrors($errors);
        else
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
        } else
        {
            $errors['full_event']= 'L\'événement est plein, vous ne pouvez plus accepter d\'équipe';
        }
        if (isset($errors))
            return back()->withErrors($errors);
        else
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
