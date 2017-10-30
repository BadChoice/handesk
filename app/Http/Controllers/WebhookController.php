<?php

namespace App\Http\Controllers;

use App\TicketEvent;

class WebhookController extends Controller
{
    public function store(){
        //dd(request()->all());
        $issueId = request('issue')["id"];
        $repository = request('repository')["name"];
        $ticketEvent = TicketEvent::where('body', "Issue created #{$issueId} at {$repository}")->first();
        dd($issueId, $repository, $ticketEvent);

    }
}
