<?php

namespace App\Listeners;

use App\Events\TicketRated;
use App\Kpi\Kpi;
use App\Kpi\RatedKpi;

class UpdateRatedKpi
{
    /**
     * Handle the event.
     *
     * @param  TicketRated  $event
     *
     * @return void
     */
    public function handle(TicketRated $event)
    {
        $this->calculateRatedKpi($event);
    }

    private function calculateRatedKpi($event)
    {
        if (! RatedKpi::doesApply($event->ticket, $event->ticket->user)) {
            return;
        }

        RatedKpi::obtain($event->ticket->created_at, $event->ticket->user_id, Kpi::TYPE_USER)->addValue($event->ticket->rating);

        if (! $event->ticket->team_id) {
            return;
        }
        RatedKpi::obtain($event->ticket->created_at, $event->ticket->team_id, Kpi::TYPE_TEAM)->addValue($event->ticket->rating);
    }
}
