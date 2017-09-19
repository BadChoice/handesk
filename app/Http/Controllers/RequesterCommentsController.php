<?php

namespace App\Http\Controllers;

use App\Ticket;

class RequesterCommentsController extends Controller
{
    public function store($public_token)
    {
        $ticket = Ticket::findWithPublicToken($public_token);
        $ticket->addComment(null, request('body'), $this->getNewStatus());

        return back();
    }

    private function getNewStatus()
    {
        if (request('solved')) {
            return Ticket::STATUS_SOLVED;
        }
        if (request('reopen')) {
            return Ticket::STATUS_OPEN;
        }

        return null;
    }
}
