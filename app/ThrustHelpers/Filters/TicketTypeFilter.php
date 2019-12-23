<?php

namespace App\ThrustHelpers\Filters;

use App\TicketType;
use BadChoice\Thrust\Filters\SelectFilter;
use Illuminate\Http\Request;

class TicketTypeFilter extends SelectFilter
{
    public function apply(Request $request, $query, $value)
    {
        if (! $value) {
            return $query;
        }

        return $query->where('ticket_type_id', $value);
    }

    public function options()
    {
        return TicketType::all()->mapWithKeys(function ($type) {
            return [$type->name => $type->id];
        })->toArray();
    }
}
