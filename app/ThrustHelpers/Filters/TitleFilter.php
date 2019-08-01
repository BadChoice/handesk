<?php

namespace App\ThrustHelpers\Filters;

use App\Ticket;
use BadChoice\Thrust\Filters\TextFilter;
use Illuminate\Http\Request;
use BadChoice\Thrust\Filters\SelectFilter;

class TitleFilter extends TextFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('title', 'like', "%{$value}%");
    }
}
