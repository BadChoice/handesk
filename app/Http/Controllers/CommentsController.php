<?php

namespace App\Http\Controllers;

use App\Ticket;

class CommentsController extends Controller
{
    public function store(Ticket $ticket) {
        $this->authorize('view', $ticket);
        if( request('private') ){
            $ticket->addNote( auth()->user(), request('body') );
        }
        else {
            $ticket->addComment(auth()->user(), request('body'), request('new_status'));
        }
        return redirect()->route('tickets.index');
    }
}
