<?php

namespace App\ThrustHelpers\Filters;

use App\Lead;
use Illuminate\Http\Request;
use BadChoice\Thrust\Filters\SelectFilter;

class LeadStatusFilter extends SelectFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('status', $value);
    }

    public function options()
    {
        return [
            ucfirst(Lead::getStatusText(Lead::STATUS_NEW))           => Lead::STATUS_NEW,
            ucfirst(Lead::getStatusText(Lead::STATUS_FIRST_CONTACT)) => Lead::STATUS_FIRST_CONTACT,
            ucfirst(Lead::getStatusText(Lead::STATUS_VISITED))       => Lead::STATUS_VISITED,
            ucfirst(Lead::getStatusText(Lead::STATUS_COMPLETED))     => Lead::STATUS_COMPLETED,
            ucfirst(Lead::getStatusText(Lead::STATUS_FAILED))        => Lead::STATUS_FAILED,
        ];
    }
}
