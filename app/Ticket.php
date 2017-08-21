<?php

namespace App;

use App\Events\TicketCommented;
use App\Events\TicketStatusUpdated;
use App\Notifications\NewComment;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends BaseModel{
    use SoftDeletes, Taggable, Assignable, Subscribable;
    
    const STATUS_NEW                = 1;
    const STATUS_OPEN               = 2;
    const STATUS_PENDING            = 3;
    const STATUS_SOLVED             = 4;
    const STATUS_CLOSED             = 5;
    const STATUS_MERGED             = 6;
    const STATUS_SPAM               = 7;

    const PRIORITY_LOW              = 1;
    const PRIORITY_NORMAL           = 2;
    const PRIORITY_HIGH             = 3;

    public static function createAndNotify($requester, $title, $body, $tags){
        $requester  = Requester::firstOrCreate( ["email" => $requester["email"] ?? null], ["name" => $requester["name"]]);
        $ticket     = $requester->tickets()->create([
            "title"         => $title,
            "body"          => $body,
            "public_token"  => str_random(24),
        ])->attachTags( $tags );

        tap(new TicketCreated($ticket), function($newTicketNotification) use ($requester) {
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
        return $this->commentsAndNotes()->where('private',false);
    }

    public function commentsAndNotes(){
        return $this->hasMany(Comment::class)->latest();
    }

    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function attachments() {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function mergedTickets(){
        return $this->belongsToMany(Ticket::class, "merged_tickets", "ticket_id", "merged_ticket_id");
    }

    protected function getAssignedNotification(){
        return new TicketAssigned($this);
    }

    public function addComment($user, $body, $newStatus = null){
        $previousStatus = $this->status;
        if($newStatus && $newStatus != $previousStatus) $this->updateStatus($newStatus);
        else                                            $this->touch();

        if( ! $this->user && $user) { $this->user()->associate($user)->save(); }

        event( new TicketStatusUpdated($this, $user,  $previousStatus) );

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
        event( new TicketCommented($this, $comment, $previousStatus) );
        return $comment;
    }

    public function addNote($user, $body){
        if( ! $this->user && $user) { $this->user()->associate($user)->save(); }
        else                        { $this->touch(); }
        return $this->comments()->create([
            "body"          => $body,
            "user_id"       => $user->id,
            "new_status"    => $this->status,
            "private"       => true,
        ]);
    }

    public function merge($user, $tickets){
        collect($tickets)->map(function($ticket) {
            return is_numeric($ticket) ? Ticket::find($ticket) : $ticket;
        })->reject(function($ticket) {
            return $ticket->status > Ticket::STATUS_SOLVED;
        })->each(function($ticket) use($user) {
            $ticket->addNote( $user, "Merged with #{$this->id}" );
            $ticket->updateStatus(Ticket::STATUS_MERGED);
            $this->mergedTickets()->attach($ticket);
        });
    }

    public function updateStatus($status){
        $this->update(["status" => $status, "updated_at" => Carbon::now() ]);
    }

    public function scopeOpen($query){
        return $query->where('status','<',Ticket::STATUS_SOLVED);
    }

    public function scopeSolved($query){
        return $query->where('status','>=',Ticket::STATUS_SOLVED);
    }

    public function canBeEdited(){
        return ! in_array($this->status, [Ticket::STATUS_CLOSED, Ticket::STATUS_MERGED]);
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

    public function getSubscribableEmail(){
        return $this->requester->email;
    }

    public function getSubscribableName(){
        return $this->requester->name;
    }

}
