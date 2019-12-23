<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCommented
{
    use Dispatchable, SerializesModels;

    public $ticket;
    public $comment;
    public $previousStatus;

    public function __construct($ticket, $comment, $previousStatus)
    {
        $this->ticket         = $ticket;
        $this->comment        = $comment;
        $this->previousStatus = $previousStatus;
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
