<?php

namespace App\Http\Controllers;

use App\Team;

class TeamAgentsController extends Controller
{
    public function index(Team $team)
    {
        return view('teams.agents', ['team' => $team]);
    }
}
