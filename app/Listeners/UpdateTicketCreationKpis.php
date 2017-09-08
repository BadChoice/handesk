<?php

namespace App\Listeners;

use App\Events\TicketCreated;

class UpdateTicketCreationKpis
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
     * @param  TicketCreated  $event
     *
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        //
    }
}
