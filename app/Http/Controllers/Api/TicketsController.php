<?php

namespace App\Http\Controllers\Api;

use App\Notifications\TicketCreated;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;

class TicketsController extends ApiController
{
    public function store(){
        $this->validate( request(), [
            "requester"     => "required|min:3",
            "title"         => "required|min:3",
        ]);

        $ticket = Ticket::make(
            request('requester'),
            request('title'),
            request('body'),
            request('tags')
        );
        return $this->respond(["id" => $ticket->id ], Response::HTTP_CREATED);
    }
}
