<?php

namespace App\ThrustHelpers\Filters;

use App\Ticket;
use Illuminate\Http\Request;
use BadChoice\Thrust\Filters\SelectFilter;

class EscalatedFilter extends SelectFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('level', $value);
    }

    public function options()
    {
        return [
            __('ticket.escalated')    => 1,
            __('ticket.nonEscalated') => 0,
        ];
    }
}
