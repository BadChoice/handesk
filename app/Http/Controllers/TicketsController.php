<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Repositories\TicketsRepository;

class TicketsController extends Controller
{
    public function index(TicketsRepository $repository)
    {
        if (request('assigned')) {
            $tickets  = $repository->assignedToMe();
        } elseif (request('unassigned')) {
            $tickets  = $repository->unassigned();
        } elseif (request('recent')) {
            $tickets = $repository->recentlyUpdated();
        } elseif (request('solved')) {
            $tickets = $repository->solved();
        } elseif (request('closed')) {
            $tickets = $repository->closed();
        } elseif (request('escalated')) {
            $tickets = $repository->escalated();
        } else {
            $tickets = $repository->all();
        }

        if (request('team')) {
            $tickets = $tickets->where('tickets.team_id', request('team'));
        }

        $tickets = $tickets->select('tickets.*')->latest('updated_at');

        return view('tickets.index', ['tickets' => $tickets->paginate(25, ['tickets.user_id'])]);
    }

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

        return redirect()->route('tickets.show', $ticket);
    }

    public function reopen(Ticket $ticket)
    {
        $ticket->updateStatus(Ticket::STATUS_OPEN);

        return back();
    }
}
