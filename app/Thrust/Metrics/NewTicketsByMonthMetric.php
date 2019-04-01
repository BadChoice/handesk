<?php

namespace App\Thrust\Metrics;

use App\Ticket;
use BadChoice\Thrust\Metrics\TrendMetric;

class NewTicketsByMonthMetric extends TrendMetric
{
    protected $range = 365;

    public function calculate()
    {
        $this->countByMonths(Ticket::class);
    }

    public function uriKey()
    {
        return 'tickets-by-month';
    }
}
