<?php

namespace App\Kpi;

use App\Ticket;

class OneTouchResolutionKpi extends Kpi
{
    const KPI = Kpi::KPI_ONE_TOUCH_RESOLUTION;

    public static function doesApply($ticket, $comment)
    {
        return $comment->new_status == Ticket::STATUS_SOLVED;
    }
}
