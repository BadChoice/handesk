<?php

namespace App\Kpi;

class FirstReplyKpi extends Kpi
{
    const KPI = Kpi::KPI_FIRST_REPLY;

    public static function doesApply($ticket, $comment)
    {
        if (! $comment->user) {
            return false;
        }
        if ($ticket->hasBeenReplied()) {
            return false;
        }

        return true;
    }
}
