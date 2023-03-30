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

    public static function validateTicketComment($requester, $ticketRequester)
    {
        if (! ($requester['name'] == $ticketRequester->name && $requester['email'] == $ticketRequester->email)) {
            throw new \Exception(__('validation.ticketCommentInjection'));
        }
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function newTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_NEW);
    }

    public function openTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_OPEN)->where('status', '=', Ticket::STATUS_PENDING);
    }

    public function closedTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_SOLVED)->where('status', '=', Ticket::STATUS_CLOSED)->where('status', '=', Ticket::STATUS_MERGED)->where('status', '=', Ticket::STATUS_SPAM);
    }

    public function shouldBeNotified()
    {
        return $this->no_reply == false;
    }
}
