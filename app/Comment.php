<?php

namespace App;

class Comment extends BaseModel
{
    protected $appends = ["author"];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function author(){
        return $this->user ? : $this->ticket->requester;
    }

    public function attachments() {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getAuthorAttribute(){
        return array_only($this->author()->toArray(),["name","email"]);
    }
}
