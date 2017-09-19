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
        if ($ticket->comments()->whereNotNull('user_id')->count() > 1) {
            return false;
        }

        return true;
    }
}
