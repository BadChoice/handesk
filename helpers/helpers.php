<?php

function createSelectArray($array, $withNull = false){
    if( ! $array) return [];
    $values = $array->pluck("name", "id")->toArray();
    if($withNull){
        return ["" => "--"] +  $values;
    }
    return $values;
}

function nameOrDash($object){
    return ($object && $object->name) ? $object->name : "--";
}

function icon($icon) {
    return FA::icon($icon);
}

function gravatar($email, $size = 30){
    $email = md5( strtolower(trim($email)) );
    //$gravatarURL = "https://www.gravatar.com/avatar/" . $email."?s=".$size."&d=mm";
    $defaultImage = urlencode("https://raw.githubusercontent.com/BadChoice/handesk/master/public/images/default-avatar.png");
    $gravatarURL = "https://www.gravatar.com/avatar/" . $email."?s=".$size."&default={$defaultImage}";
    return '<img id = '.$email.''.$size.' class="gravatar" src="'.$gravatarURL.'" width="'.$size.'">';
}