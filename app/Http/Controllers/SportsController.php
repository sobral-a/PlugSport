<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Sport;

class SportsController extends Controller
{
    public function addSport(Request $request)
    {
        $sport = new Sport();
        $sport->name = $request->name;
        return $sport->save();
    }

    public function sports()
    {
        $sports = Sport::all();
        return view('sports', compact('sports'));
    }

    public function removeSport(Sport $sport)
    {
        $sport->delete();
        return back();
    }

}
