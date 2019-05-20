<?php

namespace App\Thrust\Metrics;

use App\Ticket;
use BadChoice\Thrust\Metrics\PartitionMetric;

class TeamTicketsMetric extends PartitionMetric
{
    public function calculate()
    {
        return $this->count(Ticket::class, 'team');
    }

    public function uriKey()
    {
        return 'team-tickets';
    }
}
