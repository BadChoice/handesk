<?php

namespace App;

use App\Authenticatable\Admin;
use App\Notifications\NewComment;

class Comment extends BaseModel
{
    protected $appends = ['author'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function author()
    {
        return $this->user ?: $this->ticket->requester;
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getAuthorAttribute()
    {
        return array_only($this->author()->toArray(), ['name', 'email']);
    }

    public function notifyNewComment()
    {
        tap(new NewComment($this->ticket, $this), function ($newCommentNotification) {
            if ($this->ticket->team) {
                $this->ticket->team->notify($newCommentNotification);
            }
            if ($this->ticket->user && (! auth()->user() || auth()->user()->id !== $this->ticket->user->id)) {
                $this->ticket->user->notify($newCommentNotification);
            }
            if ($this->ticket->requester && auth()->user()) {
                $this->ticket->requester->notify($newCommentNotification);
            }
            Admin::notifyAll($newCommentNotification);
        });

        return $this;
    }
}
