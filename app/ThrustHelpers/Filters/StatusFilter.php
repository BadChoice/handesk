<?php

namespace App\ThrustHelpers\Filters;

use App\Ticket;
use Illuminate\Http\Request;
use BadChoice\Thrust\Filters\SelectFilter;

class StatusFilter extends SelectFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('status', $value);
    }

    public function options()
    {
        return [
            ucfirst(Ticket::statusNameFor(Ticket::STATUS_NEW))     => Ticket::STATUS_NEW,
            ucfirst(Ticket::statusNameFor(Ticket::STATUS_OPEN))    => Ticket::STATUS_OPEN,
            ucfirst(Ticket::statusNameFor(Ticket::STATUS_PENDING)) => Ticket::STATUS_PENDING,
            ucfirst(Ticket::statusNameFor(Ticket::STATUS_SOLVED))  => Ticket::STATUS_SOLVED,
            ucfirst(Ticket::statusNameFor(Ticket::STATUS_CLOSED))  => Ticket::STATUS_CLOSED,
            ucfirst(Ticket::statusNameFor(Ticket::STATUS_MERGED))  => Ticket::STATUS_MERGED,
            ucfirst(Ticket::statusNameFor(Ticket::STATUS_SPAM))    => Ticket::STATUS_SPAM,
        ];
    }
}
