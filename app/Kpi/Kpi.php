<?php

namespace App\Kpi;

use App\BaseModel;
use Carbon\Carbon;

class Kpi extends BaseModel {
    const TYPE_ALL  = 1;
    const TYPE_USER = 2;
    const TYPE_TEAM = 3;

    public $incrementing = false;
    public $timestamps = false;

    public static function obtain(Carbon $date,$relation_id,$type){
        return static::firstOrCreate([
            "date"          => $date->toDateString(),
            "relation_id"   => $relation_id,
            "type"          => $type
        ]);
    }

    public function addValue($value){
        $newAvg = $this->avg == null ? $value :  ($this->avg + $value)/2;
        return static::where([
            "date"          => $this->date,
            "relation_id"   => $this->relation_id,
            "type"          => $this->type
            ])->update(["avg" => $newAvg ]);
    }
}