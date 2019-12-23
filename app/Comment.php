<?php

namespace App;

use App\Authenticatable\Admin;
use App\Notifications\CommentMention;
use App\Notifications\NewComment;
use App\Services\Mentions;
use Notification;

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
            if ($this->shouldNotifyUser()) {
                $this->ticket->user->notify($newCommentNotification);
            }
            if ($this->shouldNotifyRequester()) {
                $this->ticket->requester->notify($newCommentNotification);
            }
            $mentionedUsers = Mentions::usersIn($this->body);
            Notification::send($mentionedUsers, new CommentMention($this->ticket, $this));
            Admin::notifyAll($newCommentNotification, $mentionedUsers);
        });

        return $this;
    }

    public function notifyNewNote()
    {
        return $this->notifyNewComment();
    }

    private function shouldNotifyUser()
    {
        return $this->ticket->user && (! auth()->user() || auth()->user()->id != $this->ticket->user->id);
    }

    private function shouldNotifyRequester()
    {
        return ! $this->private && $this->ticket->requester && auth()->user();
    }
}
