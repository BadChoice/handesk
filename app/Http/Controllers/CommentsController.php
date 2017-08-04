<?php

namespace App\Http\Controllers;

use App\Ticket;

class CommentsController extends Controller
{
    public function store(Ticket $ticket) {
        $this->authorize('view', $ticket);
        $ticket->addComment(auth()->user(), request('body'), request('new_status') );
        return back();
    }
}
