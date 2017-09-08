<?php

namespace App;

class UserSettings extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
