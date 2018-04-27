<?php

namespace App;

class Macro extends BaseModel
{
    use Taggable;

    const AVAILABLE_TO_ALL  = 1;
    const AVAILABLE_TO_TEAM = 2;
    const AVAILABLE_TO_ME   = 3;

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
