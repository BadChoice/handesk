<?php

namespace App;

class Ticket extends BaseModel
{
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
