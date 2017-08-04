<?php

namespace App;

use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;

class Ticket extends BaseModel
{
    const STATUS_NEW                = 1;
    const STATUS_PENDING            = 2;
    const STATUS_PENDING_CUSTOMER   = 3;
    const STATUS_SOLVED             = 4;
    const STATUS_CLOSED             = 5;

    public static function createAndNotify($requester, $title, $body, $tags){
        $requester  = Requester::firstOrCreate($requester);
        $ticket     = $requester->tickets()->create([
            "title"     => $title,
            "body"      => $body,
        ])->attachTags( request('tags') );
        $ticket->notifyCreated();

        return $ticket;
    }

    public function notifyCreated(){
        User::admin()->get()->each(function($admin){
            $admin->notify( new TicketCreated($this) );
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function requester(){
        return $this->belongsTo(Requester::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function assignTo($user){
        if( ! $user instanceof User){
            $user = User::findOrFail( $user );
        }
        $this->user()->associate($user)->save();
        $user->notify( new TicketAssigned($this) );
    }

    public function assignToTeam($team){
        if( ! $team instanceof Team){
            $team = Team::findOrFail( $team );
        }
        $this->team()->associate($team)->save();
        $team->notify( new TicketAssigned($this) );
    }

    public function attachTags($tagNames){
        collect($tagNames)->map(function($tagName){
            return Tag::firstOrCreate(["name" => $tagName]);
        })->unique('id')->each(function($tag){
            $this->tags()->attach($tag);
        });
        return $this;
    }

    public function updateStatus($status){
        $this->update(["status" => $status]);
    }

    public function statusName(){
        switch ($this->status){
            case static::STATUS_NEW                 : return "new";
            case static::STATUS_PENDING             : return "pending";
            case static::STATUS_PENDING_CUSTOMER    : return "pending-customer";
            case static::STATUS_SOLVED              : return "solved";
            case static::STATUS_CLOSED              : return "closed";
        }
    }
}
