<?php

namespace App\Http\Controllers;

use App\Ticket;

class TicketsEscalateController extends Controller
{
    public function store(Ticket $ticket)
    {
        $ticket->setLevel(1);

        return redirect()->route('tickets.index');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->setLevel(0);

        return redirect()->route('tickets.index');
    }
}
