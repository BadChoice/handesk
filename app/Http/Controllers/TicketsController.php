<?php

namespace App\Http\Controllers;

use App\Ticket;

class TicketsController extends Controller
{
    public function show(Ticket $ticket) {
        return view('tickets.show', ["ticket" => $ticket ]);
    }
}
