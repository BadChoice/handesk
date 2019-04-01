<?php

namespace App\Thrust\Metrics;

use App\Ticket;
use BadChoice\Thrust\Metrics\ValueMetric;

class RatingAverageMetric extends ValueMetric
{
    public function calculate()
    {
        return $this->average(Ticket::class, 'rating')->format(2);
    }

    public function uriKey()
    {
        return 'rating-average';
    }
}
