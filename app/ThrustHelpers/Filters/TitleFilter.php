<?php

namespace App\ThrustHelpers\Filters;

use Illuminate\Http\Request;
use BadChoice\Thrust\Filters\TextFilter;

class TitleFilter extends TextFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('title', 'like', "%{$value}%");
    }
}
