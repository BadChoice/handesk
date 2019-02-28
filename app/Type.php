<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Type extends BaseModel
{
    use Notifiable;
    protected $fillable = [
        'name',
        'is_trackable',
    ];
}