<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sport;

class ProfileController extends Controller
{
    public function profile(Request $request) {
        $user = $request->user();
        $sports = Sport::all();
        return view('profile', compact('user', 'sports'));

    }

    public function showPublic(User $user) {

        $sports = Sport::all();
        return view('profile_public', compact('user', 'sports'));

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

    public function update(Request $request) {
        $user = $request->user();

        $this->validate($request, [
            'name'         => 'required|string|min:2|max:100',
            'first_name'       => 'required|string|min:2|max:200',
             'description'  => 'string|nullable',
            'sport'        => 'integer|nullable'
        ]);
        if (isset($request->password)) {
            $this->validate($request, [
               'password' => 'string|min:6|max:100'
            ]);
            if (!isset($request->password_confirmation) || $request->password_confirmation != $request->password )
            {
                $errors['password_match']= 'Les deux passwords ne correspondent pas. Veuillez réessayer.';

                return back()->withErrors($errors);
            }
            $user->password =  bcrypt($request->password);
        }
        $user->sport_id = $request->sport;
        $user->description = $request->description;
        $user->first_name = $request->first_name;
        $user->name = $request->name;
        $user->save();
        return back();
    }
}
