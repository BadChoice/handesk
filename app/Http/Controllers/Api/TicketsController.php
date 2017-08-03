<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class TicketsController extends Controller
{
    public function store(){
        $this->validate( request() ,[
            "requester" => "required|min:3"
        ]);

        $ticket = Ticket::create([
            "requester" => request('requester'),
            "title"     => request('title'),
            "body"      => request('body'),
        ])->attachTags( request('tags') );

        return response(["id" => $ticket->id ], Response::HTTP_CREATED);
    }
}
