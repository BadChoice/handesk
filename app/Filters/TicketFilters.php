<?php

namespace App\Filters;

use Schema;

class TicketFilters
{
    public function apply($query, $filters)
    {
        $availableFields = Schema::getColumnListing('tickets');

        collect($filters)->filter(function ($value, $filter) use ($availableFields) {
            return in_array($filter, $availableFields);
        })->each(function ($value, $filter) use (&$query) {
            $query = $query->where($filter, $value);
        });

        return $query;
    }
}
