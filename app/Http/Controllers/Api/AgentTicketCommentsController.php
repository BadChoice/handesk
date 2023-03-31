<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;
use Auth;

class AgentTicketCommentsController extends ApiController
{
    public function index(Ticket $ticket)
    {
        if (! auth()->user()->can('view', $ticket)) {
            return $this->respondError("You don't have access to this ticket");
        }

        return $this->respond($ticket->commentsAndNotes);
    }

    public function ticketAll() {
        $user = Auth::user();
        if(!$user) return $this->respondError("Agent Not Found");

        if (request('status') == 'end') {
            $tickets = $user->closedTickets;
        } elseif (request('status') == 'open') {
            $tickets = $user->openTickets;
        } elseif (request('status') == 'new') {
            $tickets = $user->newTickets;
        } else {
            $tickets = $user->tickets;
        }

        return $this->respond($tickets);
    }

    public function detail($id)
    {
        $ticket = Ticket::find($id);
        if(!$ticket) return $this->respondError("Ticket Not Found");

        return $this->respond($ticket);
    }

    public function store(Ticket $ticket)
    {
        if (! auth()->user()->can('update', $ticket)) {
            return $this->respondError("You don't have access to this ticket");
        }

        if (request('private')) {
            $comment = $ticket->addNote(auth()->user(), request('body'));
        } else {
            $comment = $ticket->addComment(auth()->user(), request('body'), request('new_status'));
        }
        if (! $comment) {
            return $this->respond(['id' => null, 'message' => 'Can not create a comment with empty body'], Response::HTTP_OK);
        }

        return $this->respond(['id' => $comment->id], Response::HTTP_CREATED);
    }
}
