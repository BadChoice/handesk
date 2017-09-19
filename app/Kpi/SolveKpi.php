<?php

namespace App\Kpi;

use App\Ticket;

class SolveKpi extends Kpi
{
    const KPI = Kpi::KPI_SOLVED;

    public static function doesApply($ticket, $user, $previousStatus)
    {
        if (! $user) {
            return false;
        } //Comented by the requester
        if ($previousStatus == Ticket::STATUS_SOLVED) {
            return false;
        }
        if ($previousStatus == Ticket::STATUS_CLOSED) {
            return false;
        }

        return true;
    }
}
