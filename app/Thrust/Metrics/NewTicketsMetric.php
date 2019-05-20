<?php

namespace App\Thrust\Metrics;

use App\Ticket;
use BadChoice\Thrust\Metrics\TrendMetric;

class NewTicketsMetric extends TrendMetric
{
    public function calculate()
    {
        return $this->countByDays(Ticket::class);
    }

    public function uriKey()
    {
        return 'new-tickets';
    }
}
