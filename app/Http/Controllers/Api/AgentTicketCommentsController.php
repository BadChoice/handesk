<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;

class AgentTicketCommentsController extends ApiController
{
    public function index(Ticket $ticket)
    {
        if (! auth()->user()->can('view', $ticket)) {
            return $this->respondError("You don't have access to this ticket");
        }

        return $this->respond($ticket->commentsAndNotes);
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
