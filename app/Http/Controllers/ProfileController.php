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
            "locale"    => request('locale'),
            "email"     => request('email') ? : auth()->user()->email,
        ]);

        auth()->user()->settings()->updateOrCreate([],[
            "new_ticket_notification"       => request()->has('new_ticket_notification'),
            "ticket_assigned_notification"  => request()->has('ticket_assigned_notification'),
            "ticket_updated_notification"   => request()->has('ticket_updated_notification'),
            "new_lead_notification"         => request()->has('new_lead_notification'),
            "lead_assigned_notification"    => request()->has('lead_assigned_notification'),

            "daily_tasks_notification"      => request()->has('daily_tasks_notification'),
            "tickets_signature"             => request('tickets_signature'),
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
