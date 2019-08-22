<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Repositories\TicketsRepository;

class AgentController extends ApiController
{
    public function login()
    {
        $credentials = request()->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return $this->respond(auth()->user());
        }

        return $this->respondError('Invalid credentials');
    }

    public function index()
    {
        return $this->respond(
            (new TicketsRepository)->all()->with('requester')->get()
        );
    }
}
