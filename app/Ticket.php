<?php

namespace App;

class Ticket extends BaseModel
{
    const STATUS_NEW                = 1;
    const STATUS_PENDING            = 2;
    const STATUS_PENDING_CUSTOMER   = 3;
    const STATUS_SOLVED             = 4;
    const STATUS_CLOSED             = 5;

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function attachTags($tagNames){
        collect($tagNames)->map(function($tagName){
            return Tag::firstOrCreate(["name" => $tagName]);
        })->unique('id')->each(function($tag){
            $this->tags()->attach($tag);
        });
        return $this;
    }
}
