<?php

namespace App\ThrustHelpers\Actions;

use App\Ticket;
use Illuminate\Support\Collection;
use BadChoice\Thrust\Fields\Select;
use BadChoice\Thrust\Actions\Action;

class ChangeStatus extends Action
{
    public function fields()
    {
        return [
            Select::make('status')->options([
                    Ticket::STATUS_NEW      => ucfirst(Ticket::statusNameFor(Ticket::STATUS_NEW)),
                    Ticket::STATUS_OPEN     => ucfirst(Ticket::statusNameFor(Ticket::STATUS_OPEN)),
                    Ticket::STATUS_PENDING  => ucfirst(Ticket::statusNameFor(Ticket::STATUS_PENDING)),
                    Ticket::STATUS_SOLVED   => ucfirst(Ticket::statusNameFor(Ticket::STATUS_SOLVED)),
                    Ticket::STATUS_CLOSED   => ucfirst(Ticket::statusNameFor(Ticket::STATUS_CLOSED)),
                    Ticket::STATUS_MERGED   => ucfirst(Ticket::statusNameFor(Ticket::STATUS_MERGED)),
                    Ticket::STATUS_SPAM     => ucfirst(Ticket::statusNameFor(Ticket::STATUS_SPAM)),
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
            $ticket->updateStatus(request('status'));
        });
    }
}
