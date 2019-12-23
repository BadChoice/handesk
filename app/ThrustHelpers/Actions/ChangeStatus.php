<?php

namespace App\ThrustHelpers\Actions;

use App\Ticket;
use BadChoice\Thrust\Actions\Action;
use BadChoice\Thrust\Fields\Select;
use Illuminate\Support\Collection;

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
        $objects->filter(function ($ticket) {
            return auth()->user()->can('update', $ticket);
        })->each->updateStatus(request('status'));
    }
}
