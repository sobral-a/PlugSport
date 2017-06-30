<?php

namespace App\Http\Controllers;

use App\Team;
use App\Event;
use App\Mail\NotifByCoach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function sendEmail(Request $request, Team $team, Event $event) {
        $team_name = $team->name;
        $event_name = $event->name;
        $event_date = $event->date;


        Mail::to($team->players->where('wantsRappel', 1))->send(new NotifByCoach($team_name, $event_name, $event_date));
        return back()->with('success', 'Un mail a été envoyé à tous les joueurs de l\'équipe.');
        //return back();

    }
}
