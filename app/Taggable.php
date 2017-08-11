<?php

namespace App;

trait Taggable{

    public function tagsString($glue = ","){
        return implode($glue, $this->tags->pluck('name')->toArray() );
    }

    public function attachTags($tagNames){
        if(!is_array($tagNames)) $tagNames = explode(",",$tagNames);
        collect($tagNames)->map(function($tagName){
            return Tag::firstOrCreate(["name" => strtolower($tagName) ]);
        })->unique('id')->each(function($tag){
            $this->tags()->attach($tag);
        });
        return $this;
    }

    public function detachTag($tagName){
        $this->tags()->detach( Tag::whereName( strtolower($tagName) )->get() );
    }
}