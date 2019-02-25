<?php

namespace App\Http\Controllers;

use App\Ticket;
use GuzzleHttp\Client;

class TicketsAssignController extends Controller
{
    public function store(Ticket $ticket)
    {
        $message = '';
        if (request('team_id')) {
            $this->authorize('assignToTeam', $ticket);
            $ticket->assignToTeam(request('team_id'));
            $message = $ticket->title.' has been assigned to '.$ticket->team->name.' team!';
        }
        if (request('user_id')) {
            $ticket->assignTo(request('user_id'));
            $message = $ticket->title.' has been assigned to '.$ticket->user->name.' user!';
        }
        \Log::info($message);
        $ticket->user;
        $ticket->requester;
        $this->notificationToolBox($ticket, $message);

        return redirect()->route('tickets.index');
    }

    protected function notificationToolBox($data, $message = 'New ticket has been created!')
    {
        try {
            $client = new Client();
            $api_url = getenv('NOTIFICATION_API');
            $api_token = getenv('NOTIFICATION_API_TOKEN');
            $response = $client->get($api_url, [
                'headers' => [
                    'Authorization' => 'Bearer '.$api_token
                ],
                'query'=>[
                  'type'=>'ticket',
                  'message'=>$message,
                  'data'=>json_encode($data)
                ]
            ]);
            \Log::info($response->getBody());

            return true;
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return false;
        }
    }
}
