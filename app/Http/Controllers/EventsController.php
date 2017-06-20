<?php

namespace App\Http\Controllers;

use App\Event;
use App\Sport;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function addEvent(Request $request, User $user)
    {
        $this->validate($request, [
            'name'         => 'required|string|min:2|max:30',
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
        $event->sport = $request->sport;
        $event->user = $user;
        $event->save();

        return back();
    }

    public function events()
    {
        $sports = Sport::all();
        $events = Event::all(); //->whereDate('date','>=', Carbon::today()->toDateString())
        return view('events', compact('events', 'sports' ));
    }

    public function removeEvent(Event $event)
    {
        $event->delete();
        return back();
    }

}
