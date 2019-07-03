<?php

namespace App\Http\Controllers;

use App\Events\ApiNotificationEvent;
use App\Ticket;
use App\Events\TicketNotificationEvent;

class TicketsAssignController extends Controller
{
    public function store(Ticket $ticket)
    {
        $message = '';
        $username = false;
        if (request('team_id')) {
            $oldTeam = $ticket->team;
            $this->authorize('assignToTeam', $ticket);
            $ticket->assignToTeam(request('team_id'));
            $message = $ticket->title . ' has been assigned to ' . $ticket->team->name . ' team!';
            $username = $ticket->team->email;
            $teamUsers =  $ticket->team->members;
            if (isset($oldTeam->id)) {
                $oteamUsers =  $oldTeam->members;
                foreach ($oteamUsers as $key => $user) {
                    event(new TicketNotificationEvent($user->azure_id));
                }
            }
            foreach ($teamUsers as $key => $user) {
                event(new TicketNotificationEvent($user->azure_id));
            }
        }
        if (request('user_id')) {
            $old_user = $ticket->user;
            $ticket->assignTo(request('user_id'));
            $message = $ticket->title . ' has been assigned to ' . $ticket->user->name . ' user!';
            $username = $ticket->user->email;
            if (isset($old_user->id)) {
                event(new TicketNotificationEvent($old_user->azure_id));
            }
            event(new TicketNotificationEvent($ticket->user->azure_id));
        }
        $ticket->user;
        $ticket->requester;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = $message;
        $data['username']= $username;
        event(new ApiNotificationEvent($data));
        return redirect()->route('tickets.index');
    }
}
