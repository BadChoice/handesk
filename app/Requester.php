<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Requester extends BaseModel
{
    use Notifiable;

    public static function findOrCreate($name, $email = null)
    {
        if (! $email) {
            return self::firstOrCreate(['name' => $name]);
        }

        return self::firstOrCreate(['email' => $email], ['name' => $name]);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function openTickets()
    {
        return $this->tickets()->where('status', '<', Ticket::STATUS_SOLVED);
    }

    public function solvedTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_SOLVED);
    }

    public function closedTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_CLOSED);
    }
}
