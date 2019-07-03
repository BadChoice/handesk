<?php

namespace App\Listeners;

use App\Events\TicketNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationTicket
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
     * @param  TicketNotificationEvent  $event
     * @return void
     */
    public function handle(TicketNotificationEvent $event)
    {
        //
    }
}
