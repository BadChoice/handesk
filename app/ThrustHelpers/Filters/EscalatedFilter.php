<?php

namespace App\ThrustHelpers\Filters;

use BadChoice\Thrust\Filters\SelectFilter;
use Illuminate\Http\Request;

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
