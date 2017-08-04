<?php

namespace App\Http\Controllers;

use App\Ticket;

class RequesterCommentsController extends Controller
{
    public function store($public_token) {
        $ticket = Ticket::findWithPublicToken($public_token);
        $ticket->addComment(null, request('body'), request('solved') ? Ticket::STATUS_SOLVED : null);
        return back();
    }
}
