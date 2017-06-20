<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sport;

class SportsController extends Controller
{
    public function addSport(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:sport|min:2|max:20',
            'number' => 'required|min:1|max:20|integer',
        ]);
        $sport = new Sport();
        $sport->name = $request->name;
        $sport->number = $request->number;
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
