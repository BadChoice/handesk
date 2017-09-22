<?php

namespace App;

class TicketEvent extends BaseModel
{
    public static function make($ticket, $description)
    {
        if ($ticket instanceof Ticket) {
            $ticket->events()->create([
                'user_id' => auth()->user()->id ?? null,
                'body'    => $description,
            ]);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function author()
    {
        return $this->user ?: $this->ticket->requester;
    }
}
