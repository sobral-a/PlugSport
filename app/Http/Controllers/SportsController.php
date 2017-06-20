<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sport;

class SportsController extends Controller
{
    public function addSport(Request $request)
    {
        $sport = new Sport();
        $sport->name = $request->name;
        $sport->save();
        return back();
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
