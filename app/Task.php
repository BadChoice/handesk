<?php

namespace App;

use Carbon\Carbon;

class Task extends BaseModel
{
    protected $dates = ['datetime'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*public function scopeToday($query){
        return $query->where('completed',false)->whereBetween('datetime',[Carbon::today(), Carbon::tomorrow()]);
    }*/
}
