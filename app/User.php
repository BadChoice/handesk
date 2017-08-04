<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeAdmin($query){
        return $query->whereAdmin(true);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function teamsTickets(){
        try{
            //dd($this->teams->flatten('tickets')->toArray());
            return $this->teams->flatten('tickets');
        }catch(\Exception $e){
            dd($e->getMessage());
        }
        return $this->teams->pluck('tickets');
    }

    public function teams(){
        return $this->belongsToMany(Team::class, "memberships");
    }
}
