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