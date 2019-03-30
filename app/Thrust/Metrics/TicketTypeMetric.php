<?php

namespace App\Thrust\Metrics;

use App\Ticket;
use App\TicketType;
use BadChoice\Thrust\Metrics\PartitionMetric;

class TicketTypeMetric extends PartitionMetric
{
    public function calculate()
    {
        return $this->count(Ticket::class, 'ticket_type_id')
            ->label(function($value){
                return TicketType::find($value)->name ?? 'None';
            })->colors(function($value) {
                return TicketType::where('name', $value)->first()->color ?? '#efefef';
            });
    }

    public function uriKey()
    {
        return 'tickets-type';
    }

}