<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Notification;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeAdmin($query){
        return $query->whereAdmin(true);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class)->with('requester','user','team');
    }

    public function leads(){
        return $this->hasMany(Lead::class)->with('user','team');
    }

    public function teams(){
        return $this->belongsToMany(Team::class, "memberships")->withPivot('admin');
    }

    public function teamsTickets(){
        return Ticket::join('memberships','tickets.team_id','=','memberships.team_id')
                       ->where('memberships.user_id',$this->id)->select('tickets.*');
        //return $this->belongsToMany(Ticket::class, "memberships", "team_id", "team_id");
        //return $this->hasManyThrough(Ticket::class, Membership::class,"user_id","team_id")->with('requester','user','team');
    }

    public function teamsLeads(){
        return Lead::join('memberships','leads.team_id','=','memberships.team_id')
                ->where('memberships.user_id',$this->id)->select('leads.*');
    }

    public static function notifyAdmins( $notification ){
        Notification::send( User::admin()->get() , $notification);
    }

    public function __get($attribute){
        if($attribute == 'teamsTickets') return $this->teamsTickets()->get();
        return parent::__get($attribute);
    }
}
