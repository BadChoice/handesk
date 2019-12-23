<?php

namespace App\ThrustHelpers\Actions;

use App\Ticket;
use BadChoice\Thrust\Actions\Action;
use BadChoice\Thrust\Fields\Integer;
use Illuminate\Support\Collection;

class MergeTickets extends Action
{
    public function fields()
    {
        return [
            Integer::make('ticket_id')->rules('required'),
        ];
    }

    public function handle(Collection $objects)
    {
        Ticket::findOrFail(request('ticket_id'))->merge(auth()->user(), $objects);
    }
}
