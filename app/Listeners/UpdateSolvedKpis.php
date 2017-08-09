<?php

namespace App\Listeners;

use App\Events\TicketSolved;
use App\Kpi\Kpi;
use App\Kpi\SolveKpi;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSolvedKpis
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketSolved  $event
     * @return void
     */
    public function handle(TicketSolved $event)
    {
        $this->calculateSolvedKpi($event);
    }

    private function calculateSolvedKpi($event) {
        if( ! SolveKpi::doesApply($event->ticket, $event->user, $event->previousStatus) ) return;
        $time = $event->ticket->created_at->diffInMinutes( Carbon::now() );
        SolveKpi::obtain ( $event->ticket->created_at, $event->user->id, Kpi::TYPE_USER )->addValue( $time );

        if( ! $event->ticket->team_id) return;
        SolveKpi::obtain ( $event->ticket->created_at, $event->ticket->team_id, Kpi::TYPE_TEAM )->addValue( $time );
    }
}
