<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Ticket;

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
        if ($comment && request()->hasFile('attachment')) {
            Attachment::storeAttachmentFromRequest(request(), $comment);
        }

        return redirect()->route('tickets.index');
    }
}
