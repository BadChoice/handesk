<?php

namespace App\Listeners;

use App\Events\TicketCommented;
use App\Kpi\FirstReplyKpi;
use App\Kpi\Kpi;

class UpdateReplyKpis
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
     * @param  TicketCommented  $event
     * @return void
     */
    public function handle(TicketCommented $event) {
        if( ! $this->doesApply($event)) return;
        $this->calculateFirstReplyKpi($event);
    }

    private function doesApply($event){
        if( ! $event->comment->user) return false;
        if ( $event->ticket->comments()->whereNotNull('user_id')->count() > 1 ) return false;
        return true;
    }
    private function calculateFirstReplyKpi($event){

        FirstReplyKpi::obtain ( $event->ticket->created_at, $event->comment->user_id, Kpi::TYPE_USER )
                    ->addValue( $event->ticket->created_at->diffInMinutes($event->comment->created_at));
    }
}
