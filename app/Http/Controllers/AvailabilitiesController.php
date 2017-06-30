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
    public function teamDisponibility()
    {

        $teams = Team::with('events')->where('user_id', '=', Auth::id())->get();
        $availabilities = Availability::with('user', 'event')->get();

        return view('availability', compact('teams', 'availabilities'));
    }
}
