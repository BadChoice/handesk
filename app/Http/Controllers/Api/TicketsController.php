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
        if(!$requester) throw new \Exception('Requester Not Found', 404);

        if (request('status') == 'end') {
            $tickets = $requester->closedTickets;
        } elseif (request('status') == 'open') {
            $tickets = $requester->openTickets;
        } elseif (request('status') == 'new') {
            $tickets = $requester->newTickets;
        } else {
            $tickets = $requester->tickets;
        }

        return $this->respond($tickets);
    }

    public function detail($id)
    {
        $ticket = Ticket::find($id);
        if(!$ticket) throw new \Exception('Ticket Not Found', 404);

        return $this->respond($ticket);
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
            strip_tags(request('title')),
            strip_tags(request('body')),
            request()->all(),
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
