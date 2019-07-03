<?php

use Carbon\Carbon;

function createSelectArray($array, $withNull = false)
{
    if (!$array) {
        return [];
    }
    $values = $array->pluck('name', 'id')->toArray();
    if ($withNull) {
        return ['' => '--'] + $values;
    }

    return $values;
}

function nameOrDash($object)
{
    return ($object && $object->name) ? $object->name : '--';
}

function icon($icon)
{
    return FA::icon($icon);
}

function gravatar($email, $size = 30)
{
    $gravatarURL = gravatarUrl($email, $size);

    return '<img id = ' . $email . '' . $size . ' class="gravatar" src="' . $gravatarURL . '" width="' . $size . '">';
}

function gravatarUrl($email, $size)
{
    $email = md5(strtolower(trim($email)));
    //$gravatarURL = "https://www.gravatar.com/avatar/" . $email."?s=".$size."&d=mm";
    $defaultImage = urlencode('https://raw.githubusercontent.com/BadChoice/handesk/master/public/images/default-avatar.png');
    return 'https://www.gravatar.com/avatar/'.$email.'?s='.$size."&default={$defaultImage}";
}

function toTime($minutes)
{
    $minutes_per_day = (Carbon::HOURS_PER_DAY * Carbon::MINUTES_PER_HOUR);
    $days = floor($minutes / ($minutes_per_day));
    $hours = floor(($minutes - $days * ($minutes_per_day)) / Carbon::MINUTES_PER_HOUR);
    $mins = (int) ($minutes - ($days * ($minutes_per_day)) - ($hours * 60));

    return "{$days} Days {$hours} Hours {$mins} Mins";
}

function toPercentage($value, $inverse = false)
{
    return ($inverse ? 1 - $value : $value) * 100;
}

if (!function_exists('makeTimeTrackableField')) {

    function makeTimeTrackableField($object)
    {
        $display_time = '';
        $time_tracker = $object->timeTracker;
        $action = '';
        $url = route('tickets.time.tracker.update', $object->id);
        $timestamp = isset($time_tracker->total) ? $time_tracker->total : 0;
        if (isset($time_tracker->id)) {
            $tt_status = $time_tracker->status;
            $display_time = date('H:i:s', $time_tracker->total);

            if ($tt_status) {
                $param = '?status=0';
                $action = '<a class="action-tracker" href="' . $url . $param . '" >Pause</a>';
            } else {
                $param = '?status=1';
                $action = '<a class="action-tracker" href="' . $url . $param . '" >Resume</a>';
            }
        } else {
            $display_time = '00:00:00';
            $tt_status = 0;
            $param = '?status=2';
            $action = '<a class="action-tracker"  href="' . $url . $param . '">Resume</a>';
        }
        if (!$object->canTrackTime()) {
            $action = '';
        }
        return '<input id="total_time_stamp" type="hidden" data-status="' . $tt_status . '" value="' . $timestamp . '"></input><span id="total_timer_container"  class="label ticket-priority">' . $display_time . '</span>' . $action;
    }
}