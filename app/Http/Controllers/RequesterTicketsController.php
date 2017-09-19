<?php

namespace App\Http\Controllers;

use App\Ticket;

class RequesterTicketsController extends Controller
{
    public function show($public_token)
    {
        $ticket = Ticket::findWithPublicToken($public_token);

        return view('requester.tickets.show', ['ticket' => $ticket]);
    }
}
