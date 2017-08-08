<?php

namespace App;

class Comment extends BaseModel
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function author(){
        return $this->user ? : $this->ticket->requester;
    }
}
