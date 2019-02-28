<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeTracker extends Model
{

    public function start()
    {
        if ($this->status) {
            return false;

        }
        $current_timestamp = date_timestamp_get(date_create());
        $this->status = 1;
        $this->latest_start = $current_timestamp;
        $this->save();
        return $this;

    }
    public function stop()
    {
        $current_timestamp = date_timestamp_get(date_create());
        if (!$this->status) {
            return false;

        }
        $this->status = 0;
        $duration = $current_timestamp - $this->latest_start;
        $this->total = $this->total - $this->latest_start + $current_timestamp;
        TimeTrackerLog::create([
            'time_tracker_id' => $this->id,
            'duration' => $duration,
            'start' => $this->latest_start,
        ]);
        $this->save();
        return $this;

    }
}