<?php

namespace App;

class Tag extends BaseModel
{
    public function ticket()
    {
        return $this->morphedByMany(Ticket::class, 'taggable');
    }

    public function leads()
    {
        return $this->morphedByMany(Lead::class, 'taggable');
    }
}
