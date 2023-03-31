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

if(! function_exists('phone_to_62')){
    /**
     * Indonesian Format Phone Number
     */
    function phone_to_62($phone){
        if(is_null($phone)) return;

        if(strlen((string) $phone) <= 2) return null;

        switch ($phone[0]) {
            case '0':
                return '62' . substr($phone, 1);
                break;
            case '8':
                return '62' . $phone;
                break;
            case '6':
                if($phone[1] == '2'){
                    if($phone[2] == '0'){
                        return '62' . substr($phone, 3);
                    }else{
                        return $phone;
                    }
                }
                break;
            case '+':
                if($phone[1] == '6' && $phone[2] == '2'){
                    if($phone[3] == '0'){
                        return '62' . substr($phone, 4);
                    }else{
                        return substr($phone, 1);
                    }
                }
                break;
            default:
                return $phone;
        }
    }
}