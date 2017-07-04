<?php

namespace App\Http\Controllers;

use App\Availability;
use App\Team;
use Illuminate\Http\Request;
use App\User;
use App\Event;

use Auth;
use Illuminate\View\View;


class AvailabilitiesController extends Controller
{
    public function availability()
    {
        $teams = Team::with('events')->where('user_id', '=', Auth::id())->get();
        $availabilities = Availability::with('user')->get();
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

    public function playerAvailabilities()
    {
        $availabilities = Availability::with('user', 'event', 'team')->where('user_id', Auth::id())->get();
        return view('availability_player', compact('availabilities'));
    }

    public function setAvailable(Availability $av)
    {
        $av->status = "available";
        $av->save();
        return back();
    }

    public function setUnavailable(Availability $av)
    {
        $av->status = "unavailable";
        $av->save();
        return back();
    }

    public function delete(Availability $av)
    {
        $av->delete();
        return back();
    }

}
