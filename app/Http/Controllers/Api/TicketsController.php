<?php

namespace App\Http\Controllers\Api;

use App\Notifications\TicketCreated;
use App\Ticket;
use App\User;
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

        User::admin()->get()->each(function($admin) use($ticket){
           $admin->notify( new TicketCreated($ticket) );
        });

        return $this->respond(["id" => $ticket->id ], Response::HTTP_CREATED);
    }
}
