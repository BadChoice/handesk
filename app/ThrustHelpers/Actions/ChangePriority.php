<?php

namespace App\ThrustHelpers\Actions;

use App\Ticket;
use Illuminate\Support\Collection;
use BadChoice\Thrust\Fields\Select;
use BadChoice\Thrust\Actions\Action;

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
        $objects->each(function ($ticket) {
            if (! auth()->user()->can('update', $ticket)) {
                return;
            }
            $ticket->updatePriority(request('priority'));
        });
    }
}
