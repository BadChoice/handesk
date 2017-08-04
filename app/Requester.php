<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Requester extends BaseModel
{
    use Notifiable;

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
