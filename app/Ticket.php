<?php

namespace App;

use App\Notifications\NewComment;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;

class Ticket extends BaseModel{
    const STATUS_NEW                = 1;
    const STATUS_OPEN               = 2;
    const STATUS_PENDING            = 3;
    const STATUS_SOLVED             = 4;
    const STATUS_CLOSED             = 5;

    const PRIORITY_LOW              = 1;
    const PRIORITY_NORMAL           = 2;
    const PRIORITY_HIGH             = 3;

    public static function createAndNotify($requester, $title, $body, $tags){
        $requester  = Requester::firstOrCreate($requester);
        $ticket     = $requester->tickets()->create([
            "title"         => $title,
            "body"          => $body,
            "public_token"  => str_random(24),
        ])->attachTags( request('tags') );

        tap(new TicketCreated($ticket), function($newTicketNotification) use($requester) {
            User::notifyAdmins( $newTicketNotification );
            $requester->notify( $newTicketNotification );
        });

        return $ticket;
    }

    public static function findWithPublicToken($public_token){
        return Ticket::where("public_token",$public_token)->firstOrFail();
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
        return $this->hasMany(Comment::class)->latest();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function assignTo($user){
        if( ! $user instanceof User){
            $user = User::findOrFail( $user );
        }
        if($this->user && $this->user->id == $user->id) return;
        $this->user()->associate($user)->save();
        $user->notify( new TicketAssigned($this) );
    }

    public function assignToTeam($team){
        if( ! $team instanceof Team){
            $team = Team::findOrFail( $team );
        }
        if($this->team && $this->team->id == $team->id) return;
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

    public function addComment($user, $body, $newStatus = null){
        if($newStatus) $this->updateStatus($newStatus);
        else           $this->touch();

        if(! $this->user && $user) $this->user()->associate($user);
        if( ! $body) return;
        $comment = $this->comments()->create([
            "body"          => $body,
            "user_id"       => $user ? $user->id : null,
            "new_status"    => $newStatus ?: $this->status,
        ]);

        tap(new NewComment($this, $comment), function($newCommentNotification) {
            if( $this->team )                                                                   $this->team->notify( $newCommentNotification );
            if( $this->user && (! auth()->user() || auth()->user()->id != $this->user->id))     $this->user->notify( $newCommentNotification );
            if( $this->requester && auth()->user() )                                            $this->requester->notify( $newCommentNotification );
            User::notifyAdmins( $newCommentNotification );
        });
        return $comment;
    }

    public function updateStatus($status){
        $this->update(["status" => $status]);
    }

    public function statusName(){
        switch ($this->status){
            case static::STATUS_NEW                 : return "new";
            case static::STATUS_OPEN                : return "open";
            case static::STATUS_PENDING             : return "pending";
            case static::STATUS_SOLVED              : return "solved";
            case static::STATUS_CLOSED              : return "closed";
        }
    }
}
