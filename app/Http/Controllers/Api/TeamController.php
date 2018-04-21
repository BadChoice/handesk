<?php

namespace App\Http\Controllers\Api;

use App\Team;

class TeamController extends ApiController
{
    public function store()
    {
        $this->validate(request(), [
            'name'  => 'required|min:3',
            'email' => 'required|email',
        ]);

        return $this->respond(Team::create([
            'name'              => request('name'),
            'email'             => request('email'),
            'slack_webhook_url' => request('slack_webhook_url'),
            'token'             => str_random(24),
        ]), 201);
    }
}
