<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'name'   => $request->get('name'),
            'locale' => $request->get('locale'),
            'email'  => $request->get('email', $user->email),
        ]);

        $user->settings()->updateOrCreate([], $request->only('tickets_signature') + $this->notificationSettings($request));

        return back();
    }

    public function password(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'old'      => 'old_password:'.$user->password,
            'password' => 'confirmed|min:5',
        ]);

        $user->update(['password' => bcrypt($request->get('password'))]);

        return back();
    }

    private function notificationSettings(Request $request)
    {
        return [
            'new_ticket_notification'      => $request->has('new_ticket_notification'),
            'ticket_assigned_notification' => $request->has('ticket_assigned_notification'),
            'ticket_updated_notification'  => $request->has('ticket_updated_notification'),
            'new_lead_notification'        => $request->has('new_lead_notification'),
            'lead_assigned_notification'   => $request->has('lead_assigned_notification'),
            'daily_tasks_notification'     => $request->has('daily_tasks_notification'),
        ];
    }
}
