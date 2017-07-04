<?php

namespace App\Http\Controllers;

use App\Event;
use App\Sport;
use App\User;
use App\Team;
use App\Availability;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function addEvent(Request $request, User $user)
    {
        $this->validate($request, [
            'name'         => 'required|string|min:2|max:100',
            'adress'       => 'required|string|min:5|max:200',
            'teams_number' => 'required|integer|min:1|max:100',
            'date'         => 'required|date',
            'description'  => 'string|nullable',
            'sport'        => 'required|integer'
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->adress = $request->adress;
        $event->teams_number = $request->teams_number;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->sport_id = $request->sport;
        $event->user_id = $user->id;
        $event->save();

        return back();
    }


    public function events(User $user)
    {
        $events = \Illuminate\Database\Eloquent\Collection::make();
        if ($user->profil == 'joueur') {
            $inTeamAccepted = $user->inTeamAccepted;
            foreach ($inTeamAccepted as $team) {
                foreach ($team->events as $event) {
                    $events->push($event);
                }
            }
        }
        else {
            $sports = Sport::all();
            if($user->isAdmin)
            {
                $events = Event::all(); //->whereDate('date','>=', Carbon::today()->toDateString())
            }
            else {
                $events = $user->events; //->whereDate('date','>=', Carbon::today()->toDateString())
                $teams = Team::where('user_id', $user->id)->get();
            }
        }
        $availabilities = Availability::all();

        return view('events', compact('events', 'sports', 'teams', 'availabilities'));
    }

    public function removeEvent(Event $event)
    {
        $event->delete();
        return back();
    }

    public function eventView(Request $request, Event $event)
    {
        $sports = Sport::all();

        $user_id = $request->user()->id;
        $teams = Team::where('user_id', '=', $user_id)->get();
        return view('event', compact('event', 'sports' , 'teams'));
    }
}
