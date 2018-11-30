<?php

namespace App\Repositories;

use App\Filters\TicketFilters;

class TicketsIndexQuery
{
    public static function get(TicketsRepository $repository = null)
    {
        if (! $repository) {
            $repository = app(TicketsRepository::class);
        }

        if (request('assigned')) {
            $tickets = $repository->assignedToMe();
        } elseif (request('unassigned')) {
            $tickets = $repository->unassigned();
        } elseif (request('recent')) {
            $tickets = $repository->recentlyUpdated();
        } elseif (request('solved')) {
            $tickets = $repository->solved();
        } elseif (request('closed')) {
            $tickets = $repository->closed();
        } elseif (request('escalated')) {
            $tickets = $repository->escalated();
        } elseif (request('rated')) {
            $tickets = $repository->rated();
        } else {
            $tickets = $repository->all();
        }

        $tickets = (new TicketFilters)->apply($tickets, request()->all());

        if (request('team')) {
            $tickets = $tickets->where('tickets.team_id', request('team'));
        }

        return $tickets;
    }
}
