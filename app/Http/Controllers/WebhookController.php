<?php

namespace App\Http\Controllers;

use App\TicketEvent;
use App\Authenticatable\Admin;

class WebhookController extends Controller
{
    public function store()
    {
        //dd(request()->all());
        $issueId    = request('issue')['id'];
        $repository = request('repository')['name'];
        $newStatus  = request('changes')['status']['new'];

        if ($newStatus != 'resolved') {
            return response()->json('ok: not updating anything');
        }
        $ticketEvent = TicketEvent::where('body', "Issue created #{$issueId} at {$repository}")->first();
        if (! $ticketEvent) {
            return response()->json('ok: no ticket with this issue');
        }
        $ticketEvent->ticket->addNote(Admin::first(), 'Issue resolved');

        return response()->json("ok: Ticket {$ticketEvent->ticket->id} updated");
    }
}
