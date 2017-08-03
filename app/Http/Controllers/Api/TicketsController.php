<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;

class TicketsController extends ApiController
{
    public function store(){
        $this->validate(request(), [
            "requester" => "required|min:3",
            "title" => "required|min:3",
        ]);

        $ticket = Ticket::create([
            "requester" => request('requester'),
            "title"     => request('title'),
            "body"      => request('body'),
        ])->attachTags( request('tags') );

        return $this->respond(["id" => $ticket->id ], Response::HTTP_CREATED);
    }
}
