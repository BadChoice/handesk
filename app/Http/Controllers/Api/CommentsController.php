<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;

class CommentsController extends ApiController
{
    public function store(Ticket $ticket){
        $comment = $ticket->comments()->create([
            "body" => request('body')
        ]);
        return $this->respond(["id" => $comment->id], Response::HTTP_CREATED);
    }
}
