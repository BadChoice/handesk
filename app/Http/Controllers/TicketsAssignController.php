<?php

namespace App\Http\Controllers;

use App\Events\ApiNotificationEvent;
use App\Ticket;

class TicketsAssignController extends Controller
{
    public function store(Ticket $ticket)
    {
        $message = '';
        if (request('team_id')) {
            $this->authorize('assignToTeam', $ticket);
            $ticket->assignToTeam(request('team_id'));
            $message = $ticket->title . ' has been assigned to ' . $ticket->team->name . ' team!';
        }
        if (request('user_id')) {
            $ticket->assignTo(request('user_id'));
            $message = $ticket->title . ' has been assigned to ' . $ticket->user->name . ' user!';
        }
        $ticket->user;
        $ticket->requester;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = $message;
        event(new ApiNotificationEvent($data));
        return redirect()->route('tickets.index');
    }

}