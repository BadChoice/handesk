<?php

namespace App\Http\Controllers;

use App\Team;

class TeamMembershipController extends Controller
{
    public function index($token)
    {
        $team = Team::findByToken($token);

        return view('teams.join', ['team' => $team]);
    }

    public function store($token)
    {
        $team = Team::findByToken($token);
        if (! $team->members->contains(auth()->user())) {
            $team->members()->attach(auth()->user());
        }

        return redirect()->route('tickets.index');
    }
}
