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
        return $this->belongsToMany(User::class, "memberships")->withPivot('admin');
    }

    public function memberships(){
        return $this->hasMany(Membership::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function routeNotificationForSlack($full = false) {
        if( $full ) return $this->slack_webhook_url;
        if( $this->slack_webhook_url) return explode("?",$this->slack_webhook_url)[0];
        return null;
    }

    public static function membersByTeam(){
        return [__('team.none') => [null => "--"]] + Team::all()->mapWithKeys(function($team){
           return [$team->name => $team->members->pluck('name','id')->toArray() ];
        })->toArray();
    }
}
