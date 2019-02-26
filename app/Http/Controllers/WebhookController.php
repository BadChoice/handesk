<?php

namespace App\Http\Controllers;

use App\Idea;
use App\TicketEvent;
use App\Authenticatable\Admin;

class WebhookController extends Controller
{
    public function store()
    {
        //dd(request()->all());
        $issueId    = request('issue')['id'];
        $repository = request('repository')['full_name'];
        $newStatus  = request('issue')['state'];

        $result = $this->findAndUpdateIdeas($issueId, $repository, $newStatus);
        if ($result) {
            return $result;
        }

        return $this->findAndUpdateTickets($issueId, $repository, $newStatus);
    }

    private function findAndUpdateTickets($issue_id, $repository, $newStatus)
    {
        $ticketEvent = TicketEvent::where('body', "Issue created #{$issue_id} at {$repository}")->first();
        if (! $ticketEvent) {
            \Log::info("Issue updated: {$issue_id} at {$repository} not found");
            return response()->json('ok: no ticket with this issue');
        }
        \Log::info("Issue updated: Adding note to ticket {$ticketEvent->ticket->id}");
        $ticketEvent->ticket->addNote(Admin::first(), "Issue status updated to {$newStatus}");

        return response()->json("ok: Ticket {$ticketEvent->ticket->id} updated");
    }

    private function findAndUpdateIdeas($issue_id, $repository, $newStatus)
    {
        $idea = Idea::where('issue_id', $issue_id)->where('repository', 'like', "%{$repository}%")->first();
        if (! $idea) {
            return null;
        }
        switch ($newStatus) {
            case 'resolved': $idea->update(['status' => Idea::STATUS_RESOLVED]); break;
            case 'open': $idea->update(['status' => Idea::STATUS_OPEN]); break;
            case 'closed': $idea->update(['status' => Idea::STATUS_CLOSED]); break;
            default: $idea->update(['status' => Idea::STATUS_NEW]); break;
        }

        return response()->json("ok: Idea {$idea->id} updated");
    }
}
