<?php

namespace App\Thrust\Metrics;

use App\Ticket;
use BadChoice\Thrust\Metrics\ValueMetric;

class TicketsCountMetric extends ValueMetric
{
    public function calculate()
    {
        return $this->count(Ticket::class);
    }

    public function uriKey()
    {
        return 'tickets-count';
    }
}
