<?php

namespace App\Http\Controllers\Api;

use App\Notifications\TicketCreated;
use App\Requester;
use App\Settings;
use App\Ticket;
use Illuminate\Http\Response;

class TicketsController extends ApiController
{
    public function index()
    {
        $requester = Requester::whereName(request('requester'))->orWhere('email', '=', request('requester'))->firstOrFail();
        if (request('status') == 'solved') {
            $tickets = $requester->solvedTickets;
        } elseif (request('status') == 'closed') {
            $tickets = $requester->closedTickets;
        } else {
            $tickets = $requester->openTickets;
        }

        return $this->respond($tickets);
    }

    public function show(Ticket $ticket)
    {
        return $this->respond($ticket->load('requester', 'comments'));
    }

    public function store()
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'title'     => 'required|min:3',
        ]);

        $ticket = Ticket::createAndNotify(
            request('requester'),
            request('title'),
            request('body'),
            request('tags')
        );

        if (request('team_id')) {
            $ticket->assignToTeam(request('team_id'));
        } else {
            $this->notifyDefault($ticket);
        }

        return $this->respond(['id' => $ticket->id], Response::HTTP_CREATED);
    }

    public function update(Ticket $ticket)
    {
        $ticket->updateStatus(request('status'));

        return $this->respond(['id' => $ticket->id], Response::HTTP_OK);
    }

    private function notifyDefault($ticket)
    {
        $setting = Settings::first();
        if ($setting && $setting->slack_webhook_url) {
            $setting->notify(new TicketCreated($ticket));
        }
    }
}
