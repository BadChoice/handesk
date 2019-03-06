<?php

namespace App\Http\Controllers;

use App\User;
use BadChoice\Thrust\Controllers\ThrustController;
class UsersController extends Controller
{
    public function index()
    {   
        return (new ThrustController)->index('agent');
        // $users = User::with('teams')->paginate(25);
        // return view('users.index', ['users' => $users]);
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
}
