<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('teams')->paginate(25);

        return view('users.index', ['users' => $users]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    public function impersonate(User $user)
    {
        auth()->loginUsingId($user->id);

        return redirect()->route('tickets.index');
    }

    public function changeRole(User $user, $role)
    {   
        switch ($role) {
            case 0:
                $user->admin=!$user->admin;
                break;
            case 1:
                $user->assistant=!$user->assistant;
                break;
        }
        $user->save();
        return redirect()->route('users.index');
    }
}
