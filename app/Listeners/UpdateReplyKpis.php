<?php

namespace App\Listeners;

use App\Events\TicketCommented;
use App\Kpi\FirstReplyKpi;
use App\Kpi\Kpi;
use App\Kpi\OneTouchResolutionKpi;

class UpdateReplyKpis
{
    /**
     * Handle the event.
     *
     * @param  TicketCommented  $event
     *
     * @return void
     */
    public function handle(TicketCommented $event)
    {
        $this->calculateFirstReplyKpi($event);
        $this->calculateOneTouchResolutionKpi($event);
    }

    private function calculateFirstReplyKpi($event)
    {
        if (! FirstReplyKpi::doesApply($event->ticket, $event->comment)) {
            return;
        }
        $time = $event->ticket->created_at->diffInMinutes($event->comment->created_at);
        FirstReplyKpi::obtain($event->ticket->created_at, $event->comment->user_id, Kpi::TYPE_USER)->addValue($time);

        if (! $event->ticket->team_id) {
            return;
        }
        FirstReplyKpi::obtain($event->ticket->created_at, $event->ticket->team_id, Kpi::TYPE_TEAM)->addValue($time);
    }

    private function calculateOneTouchResolutionKpi($event)
    {
        if (! FirstReplyKpi::doesApply($event->ticket, $event->comment)) {
            return;
        }
        $score = OneTouchResolutionKpi::doesApply($event->ticket, $event->comment);

        OneTouchResolutionKpi::obtain($event->ticket->created_at, $event->comment->user_id, Kpi::TYPE_USER)->addValue($score);

        if (! $event->ticket->team_id) {
            return;
        }
        OneTouchResolutionKpi::obtain($event->ticket->created_at, $event->ticket->team_id, Kpi::TYPE_TEAM)->addValue($score);
    }
}
