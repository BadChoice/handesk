<?php

use Carbon\Carbon;

function createSelectArray($array, $withNull = false)
{
    if (! $array) {
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
    $gravatarURL  = gravatarUrl($email, $size);

    return '<img id = '.$email.''.$size.' class="gravatar" src="'.$gravatarURL.'" width="'.$size.'">';
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
    $days            = floor($minutes / ($minutes_per_day));
    $hours           = floor(($minutes - $days * ($minutes_per_day)) / Carbon::MINUTES_PER_HOUR);
    $mins            = (int) ($minutes - ($days * ($minutes_per_day)) - ($hours * 60));

    return "{$days} Days {$hours} Hours {$mins} Mins";
}

function toPercentage($value, $inverse = false)
{
    return  ($inverse ? 1 - $value : $value) * 100;
}
