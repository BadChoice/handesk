<?php

namespace App\Http\Controllers;

use App\Team;

class TeamsController extends Controller
{
    public function index(){
        return view('teams.index', ["teams" => Team::all()] );
    }
}
