<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TicketsRepository;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Auth;

class AgentTicketCommentsController extends ApiController
{
    public function index(Ticket $ticket)
    {
        return $this->respond($ticket->comments);
    }

}