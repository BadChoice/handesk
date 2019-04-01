<?php

namespace App\Thrust\Metrics;

use App\TicketEvent;
use BadChoice\Thrust\Metrics\TrendMetric;

class SolvedMetric extends TrendMetric
{
    public function calculate()
    {
        return $this->countByDays(TicketEvent::where('body', 'Status updated: solved'));
    }

    public function uriKey()
    {
        return 'solved-by-day';
    }
}
