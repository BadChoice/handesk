<?php

namespace App\Http\Controllers;

use App\Ticket;

class TicketsMergeController extends Controller
{
    public function index()
    {
        return view('tickets.merge');
    }

    //Now it is done with App\ThrustHelpers\Actions\MergeAction
    /*public function store()
    {
        Ticket::findOrFail(request('ticket_id'))->merge(auth()->user(), request('tickets'));

        return redirect()->route('tickets.index');
    }*/
}
