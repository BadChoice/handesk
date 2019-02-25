<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use App\Settings;
use App\User;
use App\Requester;
use Illuminate\Http\Response;
use App\Notifications\TicketCreated;
use GuzzleHttp\Client;

class TicketsController extends ApiController
{
    public function index()
    {
        try {
            $requester = Requester::whereName(request('requester'))->orWhere('email', '=', request('requester'))->firstOrFail();

            if (request('status') == 'solved') {
                $tickets = $requester->solvedTickets;
            } elseif (request('status') == 'closed') {
                $tickets = $requester->closedTickets;
            } else {
                $tickets = $requester->openTickets;
            }

            $user = User::where('name', request('requester'))->orWhere('email', request('requester'))->firstOrFail();
            $assignedTickets = $user->tickets;
            if (count($assignedTickets)) {
                $tickets = $tickets->merge($assignedTickets);
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }



        return $this->respond($tickets);
    }

    public function show(Ticket $ticket)
    {
        return $this->respond($ticket->load('requester', 'comments'));
    }

    public function store()
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'title'     => 'required|min:3',
        ]);

        $ticket = Ticket::createAndNotify(
            request('requester'),
            request('title'),
            request('body'),
            request('tags')
        );

        if (request('team_id')) {
            $ticket->assignToTeam(request('team_id'));
        } else {
            $this->notifyDefault($ticket);
        }
        $ticket->requester;
        $ticket->user;
        $this->notificationToolBox($ticket);
        return $this->respond(['id' => $ticket->id], Response::HTTP_CREATED);
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

    public function update(Ticket $ticket)
    {
        $ticket->updateStatus(request('status'));
        $ticket->requester;
        $ticket->user;
        $this->notificationToolBox($ticket, $ticket->title.' has been updated!');
        return $this->respond(['id' => $ticket->id], Response::HTTP_OK);
    }

    private function notifyDefault($ticket)
    {
        $setting = Settings::first();
        if ($setting && $setting->slack_webhook_url) {
            $setting->notify(new TicketCreated($ticket));
        }
    }
}
