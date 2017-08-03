<?php

namespace App;

class Team extends BaseModel
{
    public function members(){
        return $this->hasManyThrough(User::class, Membership::class);
    }

    public function memberships(){
        return $this->hasMany(Membership::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
