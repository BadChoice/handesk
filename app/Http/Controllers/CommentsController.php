<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Attachment;

class CommentsController extends Controller
{
    public function store(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        if (request('private')) {
            $comment = $ticket->addNote(auth()->user(), request('body'));
        } else {
            $comment = $ticket->addComment(auth()->user(), request('body'), request('new_status'));
        }
        if (request()->hasFile('attachment')) {
            Attachment::storeAttachmentFromRequest(request(), $comment);
        }

        return redirect()->route('tickets.index');
    }
}
