<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function show(){
        return view('profile.show', ["user" => auth()->user() ]);
    }

    public function update(){
        auth()->user()->update([
            "name"      => request('name'),
            "language"  => request('language'),
            "email"     => request('email') ? : auth()->user()->email,
        ]);

        auth()->user()->settings()->updateOrCreate([],[
            "daily_tasks_notification" => request()->has('daily_tasks_notification'),
            "tickets_signature"        => request('tickets_signature'),
        ]);

        return back();
    }

    public function password(){
        $this->validate(request(), [
            "old"       => "old_password:". auth()->user()->password,
            "password"  => "confirmed|min:5"
        ]);
        auth()->user()->update(["password" => bcrypt(request('password'))]);
        return back();
    }
}
