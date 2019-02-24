<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Repositories\TicketsIndexQuery;
use App\Repositories\TicketsRepository;
use BadChoice\Thrust\Controllers\ThrustController;
use GuzzleHttp\Client;

class TicketsController extends Controller
{
    public function index()
    {
        return (new ThrustController)->index('tickets');
    }

    /*public function index(TicketsRepository $repository)
    {
        $ticketsQuery = TicketsIndexQuery::get($repository);
        $ticketsQuery = $ticketsQuery->select('tickets.*')->latest('updated_at');

        return view('tickets.index', ['tickets' => $ticketsQuery->paginate(25, ['tickets.user_id'])]);
    }*/

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return view('tickets.show', ['ticket' => $ticket]);
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'title'     => 'required|min:3',
            'body'      => 'required',
            'team_id'   => 'nullable|exists:teams,id',
        ]);
        $ticket = Ticket::createAndNotify(request('requester'), request('title'), request('body'), request('tags'));
        $ticket->updateStatus(request('status'));

        if (request('team_id')) {
            $ticket->assignToTeam(request('team_id'));
        }
        $ticket->requester;
        $this->notificationToolBox($ticket);
        return redirect()->route('tickets.show', $ticket);
    }
    protected function notificationToolBox($data)
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
    public function reopen(Ticket $ticket)
    {
        $ticket->updateStatus(Ticket::STATUS_OPEN);

        return back();
    }

    public function update(Ticket $ticket)
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'priority'  => 'required|integer',
            //'title'      => 'required|min:3',
        ]);
        $ticket->updateWith(request('requester'), request('priority'));

        return back();
    }
}
