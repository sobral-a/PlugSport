<?php

namespace App\Http\Controllers;

use App\Availability;
use App\User;
use Illuminate\Http\Request;
use App\Event;
use App\Sport;
use App\Team;

class PlayersController extends Controller
{
    public function removeUserTeam(Team $team, User $user)
    {
        $availability = Availability::where('team_id', $team->id)->where('user_id', $user->id)->get(['id']);
        Availability::destroy($availability->toArray());
        $team->players()->detach($user);
        return back();
    }

    public function addUserTeam(Team $team, User $user)
    {
        $nb = Sport::find($team->sport_id)->number;
        $count = 0;
        foreach ($team->players as $p)
        {
            if ($p->pivot->status == 'player')
            {
                $count++;
            }
        }
        if ($count < $nb)
        {
            $team->players()->attach($user);
        }
        else
        {
            $errors['full_team']= 'L\'équipe est pleine, il n\'est plus possible de candidater';
        }
        if (isset($errors))
            return back()->withErrors($errors);
        else
            return back();
    }

    public function setDenied(Team $team, User $user)
    {
        $player = $team->players()->where('id', $user->id)->get()->first();
        $player->pivot->status = 'denied';
        $player->pivot->save();
        return back();
    }

    public function setPlayer(Team $team, User $user)
    {
        $nb = Sport::find($team->sport_id)->number;
        $count = 0;
        foreach ($team->players as $p)
        {
            if ($p->pivot->status == 'player')
            {
                $count++;
            }
        }

        if ($count < $nb)
        {
            $player = $team->players()->where('id', $user->id)->get()->first();
            $player->pivot->status = 'player';
            $player->pivot->save();
        }
        else
        {
            $errors['full_team']= 'L\'équipe est pleine, vous ne pouvez plus accepter de joueur';
        }
        if (isset($errors))
            return back()->withErrors($errors);
        else
            return back();
    }
}
