<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;

class CommentsController extends ApiController
{
    public function store(Ticket $ticket){
        $comment = $ticket->addComment(null, request('body'), request('new_status'));
        return $this->respond(["id" => $comment->id], Response::HTTP_CREATED);
    }
}
