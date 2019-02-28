<?php

namespace App\Http\Controllers;

use App\Events\ApiNotificationEvent;
use App\Thrust\Fields\TimeTracker;
use App\Ticket;
use App\TimeTracker as TT;
use App\TimeTrackerLog;
use App\Type;
use BadChoice\Thrust\Controllers\ThrustController;
use Illuminate\Support\Facades\Request;

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
        $types = Type::all();

        return view('tickets.show', ['ticket' => $ticket, 'types' => $types]);
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'title' => 'required|min:3',
            'body' => 'required',
            'team_id' => 'nullable|exists:teams,id',
            'type_id' => 'required|exists:types,id',
        ]);
        $ticket = Ticket::createAndNotify(request('requester'), request('title'), request('body'), request('tags'), request('type_id'));
        $ticket->updateStatus(request('status'));

        if (request('team_id')) {
            $ticket->assignToTeam(request('team_id'));
        }
        $ticket->requester;
        $ticket->user;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = $ticket->title . ' has been updated!';
        event(new ApiNotificationEvent($data));
        return redirect()->route('tickets.show', $ticket);
    }

    public function updateTimeTracker(Ticket $ticket, Request $request)
    {
        try {
            $status = request('status');
            $timeTracker = $ticket->timeTracker;
            if (!isset($timeTracker->id)) {
                $timeTracker = new TT();
                $timeTracker->ticket_id = $ticket->id;
            }
            $current_timestamp = date_timestamp_get(date_create());
            switch ($status) {
                case '0':
                    $timeTracker->stop();
                    break;
                case '1':
                case '2':
                    $timeTracker->start();
                    break;
                default:
                    break;
            }
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }

        return back();

    }

    public function reopen(Ticket $ticket)
    {
        $ticket->updateStatus(Ticket::STATUS_OPEN);
        $ticket->updateWith(request('requester'), request('priority'));
        $ticket->requester;
        $ticket->user;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = $ticket->title . ' has been reopened!';
        event(new ApiNotificationEvent($data));
        return back();
    }

    public function update(Ticket $ticket)
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'priority' => 'required|integer',
            'type_id' => 'required',
            //'title'      => 'required|min:3',
        ]);
        $ticket->updateWith(request('requester'), request('priority'), request('type_id'));
        $ticket->requester;
        $ticket->user;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = $ticket->title . ' has been updated!';
        event(new ApiNotificationEvent($data));
        return back();
    }
}