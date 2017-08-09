<?php

namespace App\Kpi;


use App\Ticket;

class SolveKpi extends Kpi
{

    const KPI          = Kpi::KPI_SOLVED;

    public static function doesApply($ticket, $comment, $previousStatus){
        if($comment->user_id == null)                        { return false; } //Comented by the requester
        if( $previousStatus == Ticket::STATUS_SOLVED )       { return false; }
        if( $previousStatus == Ticket::STATUS_CLOSED )       { return false; }
        if( $comment->new_status != Ticket::STATUS_SOLVED)   { return false; }
        return true;
    }
}
