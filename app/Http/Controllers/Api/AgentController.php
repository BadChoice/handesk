<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TicketsRepository;

class AgentController extends ApiController
{
    public function index()
    {
        return $this->respond(
            (new TicketsRepository)->all()->with('requester')->get()
        );
    }

}