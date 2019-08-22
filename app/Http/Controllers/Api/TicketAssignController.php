<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;

class TicketAssignController extends ApiController
{
    public function store(Ticket $ticket)
    {
        $ticket->assignTo(request('user'));

        return $this->respond([], Response::HTTP_CREATED);
    }
}
