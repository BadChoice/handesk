<?php

namespace App\Http\Controllers;

use App\Ticket;

class TicketsController extends Controller
{
    public function show(Ticket $ticket) {
        $this->authorize('view', $ticket);
        return view('tickets.show', ["ticket" => $ticket ]);
    }
}
