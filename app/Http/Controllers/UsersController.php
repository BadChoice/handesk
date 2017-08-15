<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;

class UsersController extends Controller
{
    public function index(){
        $users = User::with('teams')->paginate(25);
        return view('users.index', ["users" => $users] );
    }
}
