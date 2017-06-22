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
        //TODO:test si nombre de personnes qui sont dans l'équipe est atteint

        $nb = Sport::find($team->sport_id)->number;
        //TODO: check only the players (status)
        if (count($team->players) < $nb)
        {
            $team->players()->attach($user);
        }
        //else error
        return back();
    }

    public function setDenied(Team $team, User $user)
    {
        //test si nombre de personnes est atteint
        //TODO: check only the players (status)
        $player = $team->players()->where('id', $user->id)->get()->first();
        $player->pivot->status = 'denied';
        $player->pivot->save();
        return back();
    }

    public function setPlayer(Team $team, User $user)
    {
        //TODO:test si nombre de personnes qui sont dans l'équipe est atteint
        $nb = Sport::find($team->sport_id)->number;
        //TODO: check only the players (status)
        if (count($team->players) < $nb)
        {
            $player = $team->players()->where('id', $user->id)->get()->first();
            $player->pivot->status = 'player';
            $player->pivot->save();
        }
        //else error
        return back();
    }

}
