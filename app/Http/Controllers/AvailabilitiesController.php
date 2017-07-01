<?php

namespace App\Http\Controllers;

use App\Availability;
use App\Team;
use Illuminate\Http\Request;
use App\User;
use App\Event;

use Auth;



class AvailabilitiesController extends Controller
{
    public function availability()
    {
        $teams = Team::with('events')->where('user_id', '=', Auth::id())->get();
        $availabilities = Availability::with('user', 'event')->get();
        return view('availability', compact('teams', 'availabilities'));
    }

    public function checkTeamAvailability(Team $team, Event $event)
    {
        foreach ($team->players as $player)
        {
            $av = new Availability();
            $av->user_id = $player->id;
            $av->event_id = $event->id;
            $av->team_id = $team->id;
            $av->save();
        }
        return back();
    }
}
