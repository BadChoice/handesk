<?php

namespace App\Kpi;

class RatedKpi extends Kpi
{
    const KPI = Kpi::KPI_RATING;

    public static function doesApply($ticket, $user)
    {
        return $user != null;
    }
}
