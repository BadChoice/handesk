<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function show(){
        return view('profile.show', ["user" => auth()->user() ]);
    }

    public function update(){
        auth()->user()->update([
            "name"  => request('name'),
            "email" => request('email') ? : auth()->user()->email,
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
