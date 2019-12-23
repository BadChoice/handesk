<?php

namespace App\ThrustHelpers\Filters;

use BadChoice\Thrust\Filters\TextFilter;
use Illuminate\Http\Request;

class TitleFilter extends TextFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('title', 'like', "%{$value}%");
    }
}
