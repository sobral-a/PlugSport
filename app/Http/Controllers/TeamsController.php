<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Sport;
use App\User;
use App\Team;


class TeamsController extends Controller
{
    public function addTeam(Request $request, User $user)
    {
        $this->validate($request, [
            'name'  => 'required|string|min:2|max:100',
            'sport' => 'required|integer'
        ]);

        $team = new Team();
        $team->name = $request->name;
        $team->sport_id = $request->sport;
        $team->user_id = $user->id;
        $team->save();

        return back();
    }

    public function teamsAdmin()
    {
        $sports = Sport::all();
        $teams = Team::all(); //->whereDate('date','>=', Carbon::today()->toDateString())
        return view('events_admin', compact('teams', 'sports' ));
    }

    public function teams(User $user)
    {
        $sports = Sport::all();
        $teams = $user->teams;
        $allTeams = Team::where('user_id', '!=', $user->id)->get();
        return view('teams', compact('teams', 'sports', "allTeams" ));
    }

    public function removeTeam(Team $team)
    {
        $team->delete();
        return back();
    }

    public function banTeam(Team $team)
    {
        $team->banned = 1;
        $team->save();
        return back();
    }

    public function allowTeam(Team $team)
    {
        $team->banned = 0;
        $team->save();
        return back();
    }

    public function teamView(Team $team)
    {
        $sports = Sport::all();
        $team = Team::with('user', 'sport', 'players')->where('id', '=', $team->id)->get();
        return view('team', compact('team', 'sports' ));
    }

    public function playerTeams(User $user)
    {

        $user = User::with('inTeams')->where('id', '=', $user->id)->get();
        $userTeamsIds = [];
        foreach ($user->first()->inTeams as $team)
        {
                $userTeamsIds[] = $team->id;
        }
        $allTeams = Team::with('sport')->whereNotIn('id', $userTeamsIds)->get();
        return view('teams_player', compact('allTeams', 'user' ));
    }
}