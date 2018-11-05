<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketsStatusController extends Controller
{
    public function update(Request $request)
    {
        foreach ($request->input('tickets') as $ticketId) {
            $ticket = Ticket::findOrFail($ticketId);
            $this->authorize('view', $ticket);
            $ticket->updateStatus($request->input('status'));
        }
    }
}
