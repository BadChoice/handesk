<?php

namespace App\ThrustHelpers\Filters;

use App\Ticket;
use BadChoice\Thrust\Filters\SelectFilter;
use Illuminate\Http\Request;

class PriorityFilter extends SelectFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('priority', $value);
    }

    public function options()
    {
        return [
            ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_LOW))     => Ticket::PRIORITY_LOW,
            ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_NORMAL))  => Ticket::PRIORITY_NORMAL,
            ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_HIGH))    => Ticket::PRIORITY_HIGH,
            ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_BLOCKER)) => Ticket::PRIORITY_BLOCKER,
        ];
    }
}
