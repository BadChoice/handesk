<?php

namespace App\Kpi;

use App\Ticket;

class ReopenedKpi extends Kpi
{
    const KPI = Kpi::KPI_REOPENED;

    public static function score($ticket, $previousStatus)
    {
        if (! $ticket->user_id) {
            return;
        }
        if ($previousStatus == Ticket::STATUS_SOLVED && $ticket->status < Ticket::STATUS_SOLVED) {
            return -1;
        }
        if ($previousStatus == Ticket::STATUS_CLOSED && $ticket->status < Ticket::STATUS_SOLVED) {
            return -1;
        }
        if ($previousStatus < Ticket::STATUS_SOLVED && Ticket::STATUS_SOLVED) {
            return 1;
        }

        return 0;
    }
}
