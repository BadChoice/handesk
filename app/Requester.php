<?php

namespace App;

class Requester extends BaseModel
{
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
