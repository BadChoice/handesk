<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Team extends BaseModel
{
    use Notifiable;

    public static function findByToken($token){
        return Team::where('token',$token)->firstOrFail();
    }

    public function members(){
        return $this->belongsToMany(User::class, "memberships");
    }

    public function memberships(){
        return $this->hasMany(Membership::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function routeNotificationForSlack() {
        return $this->slack_webhook_url;
    }
}
