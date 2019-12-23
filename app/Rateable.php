<?php

namespace App;

use App\Authenticatable\Admin;
use App\Events\TicketRated;
use App\Notifications\TicketRatedNotification;

trait Rateable
{
    public function canBeRated($rating)
    {
        if (! $rating) {
            return false;
        }
        if ($rating < 0 || $rating > 5) {
            return false;
        }
        if ($this->status != Ticket::STATUS_SOLVED && $this->status != Ticket::STATUS_CLOSED) {
            return false;
        }
        if ($this->rating) {
            return false;
        }

        return true;
    }

    public function rate($rating)
    {
        if (! $this->canBeRated($rating)) {
            return false;
        }

        $this->update(['rating' => $rating]);
        TicketEvent::make($this, 'Ticket rated with: '.$rating);
        tap(new TicketRatedNotification($this), function ($notification) {
            if ($this->user) {
                $this->user->notify($notification);
            }
            Admin::notifyAll($notification);
        });
        event(new TicketRated($this));

        return true;
    }
}
