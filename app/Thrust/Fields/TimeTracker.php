<?php

namespace App\Thrust\Fields;

use BadChoice\Thrust\Fields\Relationship;

class TimeTracker extends Relationship
{
    public $showInEdit = false;

    public function displayInIndex($object)
    {
        $display_time = '';
        $time_tracker = $object->timeTracker;
        $action = '';
        $url = route('tickets.time.tracker.update', $object->id);

        if (isset($time_tracker->id)) {
            $tt_status = $time_tracker->status;
            $display_time = date('H:i:s', $time_tracker->total);
            if ($tt_status) {
                $param = '?status=0';
                $action = '<a class="action-tracker" href="' . $url . $param . '" ><i class="fa fa-stop " aria-hidden="true"></i></a>';
            } else {
                $param = '?status=1';
                $action = '<a class="action-tracker" href="' . $url . $param . '" ><i class="fa fa-play " aria-hidden="true"></i></a>';
            }
        } else {
            $display_time = '00:00:00';
            $param = '?status=2';
            $action = '<a class="action-tracker"  href="' . $url . $param . '"><i class="fa fa-play " aria-hidden="true"></i></a>';
        }
        $action = '';

        if (!$object->canTrackTime()) {
            return '<span class="label ticket-priority-normal">--</span>';

        }
        return '<span class="label ticket-priority-normal">' . $display_time . '</span>';
    }

    public function displayInEdit($object, $inline = false)
    {
    }
}