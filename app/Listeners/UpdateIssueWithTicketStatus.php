<?php

namespace App\Listeners;

use App\Ticket;
use App\Services\IssueCreator;
use App\Events\TicketStatusUpdated;

class UpdateIssueWithTicketStatus
{
    public function handle(TicketStatusUpdated $event)
    {
        $issueId = $event->ticket->getIssueId();
        if (! $issueId) {
            return;
        }
        if ($event->ticket->status < Ticket::STATUS_SOLVED) {
            return;
        }
        $note = $event->ticket->findIssueNote();

        $start      = strpos($note->body, '.org');
        $end        = strpos($note->body, '/issues');
        $repository = explode('/', substr($note->body, $start + 5, $end - $start - 5));

        app(IssueCreator::class)->createComment($repository[0], $repository[1], $issueId, "Ticket updated to {$event->ticket->statusName()}");
    }
}
