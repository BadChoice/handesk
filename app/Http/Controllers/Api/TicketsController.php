<?php

namespace App\Http\Controllers\Api;

use App\Events\ApiNotificationEvent;
use App\Notifications\TicketCreated;
use App\Requester;
use App\Settings;
use App\Ticket;
use App\User;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Response;

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
            'title' => 'required|min:3',
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
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = 'New ticket has been created!';
        event(new ApiNotificationEvent($data));

        return $this->respond(['id' => $ticket->id], Response::HTTP_CREATED);
    }

    public function update(Ticket $ticket)
    {
        $ticket->updateStatus(request('status'));
        $ticket->requester;
        $ticket->user;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = $ticket->title . ' has been updated!';
        event(new ApiNotificationEvent($data));
        return $this->respond(['id' => $ticket->id], Response::HTTP_OK);
    }

    private function notifyDefault($ticket)
    {
        $setting = Settings::first();
        if ($setting && $setting->slack_webhook_url) {
            $setting->notify(new TicketCreated($ticket));
        }
    }
    public function updateRating($id)
    {
        try {
            $rating = request('rating');
            $rating = is_numeric($rating) ? $rating : 0;
            $ticket = Ticket::findOrFail($id);
            $ticket->rating = $rating;
            $ticket->status = 5;
            $ticket->save();
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([], 500);
            //throw $th;
        }

    }

    public function assignTicket($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);

            if (request('team_id')) {
                $this->authorize('assignToTeam', $ticket);
                $ticket->assignToTeam(request('team_id'));
            }
            if (request('user_id')) {
                $ticket->assignTo(request('user_id'));
            }
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json([], 500);
        }

    }

}