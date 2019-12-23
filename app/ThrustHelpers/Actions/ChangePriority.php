<?php

namespace App\ThrustHelpers\Actions;

use App\Ticket;
use BadChoice\Thrust\Actions\Action;
use BadChoice\Thrust\Fields\Select;
use Illuminate\Support\Collection;

class ChangePriority extends Action
{
    public function fields()
    {
        return [
            Select::make('priority')->options([
                    Ticket::PRIORITY_LOW       => ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_LOW)),
                    Ticket::PRIORITY_NORMAL    => ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_NORMAL)),
                    Ticket::PRIORITY_HIGH      => ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_HIGH)),
                    Ticket::PRIORITY_BLOCKER   => ucfirst(Ticket::priorityNameFor(Ticket::PRIORITY_BLOCKER)),
                ]
            ),
        ];
    }

    public function handle(Collection $objects)
    {
        $objects->filter(function ($ticket) {
            return auth()->user()->can('update', $ticket);
        })->each->updatePriority(request('priority'));
    }
}
