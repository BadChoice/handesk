<?php

namespace App\Http\Controllers;

use App\User;
use BadChoice\Thrust\Controllers\ThrustController;
use Hash;

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

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        User::create([
            'name'     => request('name'),
            'email'    => request('email'),
            'password' => Hash::make(request('password')),
            'token'    => str_random(60),
        ]);

        return back();
    }

    public function impersonate(User $user)
    {
        auth()->loginUsingId($user->id);

        return redirect()->route('tickets.index');
    }
}
