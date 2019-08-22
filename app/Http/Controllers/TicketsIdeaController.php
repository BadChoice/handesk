<?php

namespace App\Http\Controllers;

use App\Ticket;

class TicketsIdeaController extends Controller
{
    public function store(Ticket $ticket)
    {
        $this->authorize('create-idea', $ticket);
        $this->validateItIsNotAnIdeaYet($ticket);
        $idea = $ticket->createIdea();

        return redirect()->route('ideas.show', $idea);
    }

    private function validateItIsNotAnIdeaYet($ticket)
    {
        if ($ticket->getIdeaId()) {
            throw new \Exception('It has already been created as an idea');
        }
    }
}
