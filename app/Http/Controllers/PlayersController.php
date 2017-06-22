<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Event;
use App\Sport;
use App\Team;

class PlayersController extends Controller
{
    public function removeUserTeam(Team $team, User $user)
    {
        $team->players()->detach($user);
        return back();
    }

    public function addUserTeam(Team $team, User $user)
    {
        //test si nombre de personnes est atteint
        $nb = Sport::find($team->sport_id)->number;
        if (count($team->players) < $nb)
        {
            $team->players()->attach($user);
        }
        //else error
        return back();
    }

}
