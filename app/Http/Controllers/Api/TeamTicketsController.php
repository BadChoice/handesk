<?php

namespace App\Http\Controllers\Api;

use App\Team;

class TeamTicketsController extends ApiController
{
    public function index(Team $team)
    {
        if (request('status') == 'solved') {
            $tickets = $team->solvedTickets();
        } elseif (request('status') == 'closed') {
            $tickets = $team->closedTickets();
        } else {
            $tickets = $team->openTickets();
        }

        if (request('count')) {
            return $this->respond(['count' => $tickets->count()]);
        }

        return $this->respond($tickets->get());
    }
}
