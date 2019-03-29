<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;

class CommentsController extends ApiController
{
    public function store(Ticket $ticket)
    {
        $comment = $ticket->addComment(null, request('body'), request('new_status'));
        if (! $comment) {
            return $this->respond(['id' => null, 'message' => 'Can not create a comment with empty body'], Response::HTTP_OK);
        }

        return $this->respond(['id' => $comment->id], Response::HTTP_CREATED);
    }
}
