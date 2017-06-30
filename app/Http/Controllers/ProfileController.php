<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request) {

        if ($request->user()->profil == 'joueur') {

            return view('profile_user');
        }
    }
    public function updateRappel(Request $request) {

        $user = $request->user();
        if(isset($_POST['notif'])) {
            $user->wantsRappel = 1;
        }
        else
            $user->wantsRappel = 0;
        $user->save();
        return back();
    }
}
