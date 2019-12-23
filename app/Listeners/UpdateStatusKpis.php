<?php

namespace App\Listeners;

use App\Events\TicketStatusUpdated;
use App\Kpi\Kpi;
use App\Kpi\ReopenedKpi;
use App\Kpi\SolveKpi;
use App\Ticket;
use Carbon\Carbon;

class UpdateStatusKpis
{
    public function handle(TicketStatusUpdated $event)
    {
        $this->calculateSolvedKpi($event);
        $this->calculateReopenedKpi($event);
    }

    private function calculateSolvedKpi($event)
    {
        if ($event->ticket->status != Ticket::STATUS_SOLVED) {
            return;
        }

        if (! SolveKpi::doesApply($event->ticket, $event->user, $event->previousStatus)) {
            return;
        }
        $time = $event->ticket->created_at->diffInMinutes(Carbon::now());
        SolveKpi::obtain($event->ticket->created_at, $event->user->id, Kpi::TYPE_USER)->addValue($time);

        if (! $event->ticket->team_id) {
            return;
        }
        SolveKpi::obtain($event->ticket->created_at, $event->ticket->team_id, Kpi::TYPE_TEAM)->addValue($time);
    }

    private function calculateReopenedKpi($event)
    {
        $score = ReopenedKpi::score($event->ticket, $event->previousStatus);
        if ($score == 0) {
            return;
        }

        ReopenedKpi::obtain($event->ticket->created_at, $event->ticket->user_id, Kpi::TYPE_USER)->addValue($score);

        if (! $event->ticket->team_id) {
            return;
        }
        ReopenedKpi::obtain($event->ticket->created_at, $event->ticket->team_id, Kpi::TYPE_TEAM)->addValue($score);
    }
}
