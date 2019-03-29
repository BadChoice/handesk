<?php

namespace App\Thrust\Metrics;

use BadChoice\Thrust\Metrics\TrendMetric;
use App\Ticket;

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