<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Services\IssueCreator;

class TicketsIssueController extends Controller
{
    public function store(IssueCreator $issueCreator, Ticket $ticket)
    {
        $this->authorize('create-issue', $ticket);
        $this->validateSubjectAndSummary($ticket);
        $this->validateIssueNotAlreadyCreated($ticket);
        $ticket->createIssue($issueCreator, request('repository'));

        return back();
    }

    private function validateSubjectAndSummary($ticket)
    {
        if (! $ticket->summary || ! $ticket->subject) {
            throw new \Exception('No subject or summary defined');
        }
    }

    private function validateIssueNotAlreadyCreated($ticket)
    {
        if ($ticket->getIssueId()) {
            throw new \Exception('Issue already created');
        }
    }
}
