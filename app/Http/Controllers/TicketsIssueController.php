<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Services\IssueCreator;

class TicketsIssueController extends Controller
{
    public function store(IssueCreator $issueCreator, Ticket $ticket)
    {
        $this->authorize('create-issue', $ticket);
        $this->validateIssueNotAlreadyCreated($ticket);
        $ticket->createIssue($issueCreator, request('repository'));

        return back();
    }

    private function validateIssueNotAlreadyCreated($ticket)
    {
        if ($ticket->getIssueId()) {
            throw new \Exception('Issue already created');
        }
    }
}
