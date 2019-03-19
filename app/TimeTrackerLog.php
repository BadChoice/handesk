<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeTrackerLog extends Model
{
    //
    protected $fillable = [
        'time_tracker_id',
        'start',
        'status',
        'duration',
    ];
}