<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStatusUpdated
{
    use Dispatchable,  SerializesModels;

    public $ticket;
    public $previousStatus;
    public $user;

    public function __construct($ticket, $user, $previousStatus)
    {
        $this->ticket         = $ticket;
        $this->previousStatus = $previousStatus;
        $this->user           = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
