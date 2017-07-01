<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Sport;
use App\User;
use App\Team;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $events = \Illuminate\Database\Eloquent\Collection::make();
        if ($user->profil == 'joueur') {
            $inTeams = $user->inTeamAccepted;
            foreach ($inTeams as $team) {
                foreach ($team->events as $event) {
                    $events->push($event);
                }
            }
            return view('home', compact('events', 'inTeams'));

        }
        else if ($user->isAdmin) {
            $events = Event::all();
            $allTeams = Team::all();

            return view('home', compact('events', 'allTeams'));
        }
        else if ($user->profil == 'entraineur') {
            $events = $user->events; //->whereDate('date','>=', Carbon::today()->toDateString())
            $teams = Team::where('user_id', $user->id)->get();

            return view('home', compact('events', 'teams'));
        }


    }
}
