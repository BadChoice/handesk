<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Events\ApiNotificationEvent;
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
        $ticket->user;
        $ticket->requester;
        $data = ['title' => auth()->user()->name . ' has been comment', 'content' => request('body')];
        $data['data'] = json_encode($ticket);
        $data['type'] = 'comment';
        $data['comment'] = $comment;
        $data['ticket_status'] = request('new_status');
        event(new ApiNotificationEvent($data));
        return redirect()->route('tickets.index');
    }
}