<?php

namespace App\Kpi;

use App\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Kpi extends BaseModel {
    const TYPE_ALL  = 1;
    const TYPE_USER = 2;
    const TYPE_TEAM = 3;

    const KPI_FIRST_REPLY           = 1;
    const KPI_SOLVED                = 2;
    const KPI_ONE_TOUCH_RESOLUTION  = 3;
    const KPI_REOPENED              = 4;

    public $incrementing    = false;
    public $timestamps      = false;
    protected $table        = 'kpis';

    const KPI               = null;

    public static function obtain(Carbon $date,$relation_id,$type){
        return static::firstOrCreate([
            "date"          => $date->toDateString(),
            "relation_id"   => $relation_id,
            "type"          => $type,
            "kpi"           => static::KPI
        ]);
    }

    public function addValue($value){
        return static::where([
                "date"          => $this->date,
                "relation_id"   => $this->relation_id,
                "type"          => $this->type,
                "kpi"           => $this->kpi
            ])->update([
                "total" => $this->total  + $value,
                "count" => $this->count +1
            ]);
    }

    public static function forUser($user){
        $result =  static::where(['relation_id' => $user->id, 'type' => Kpi::TYPE_USER, "kpi" => static::KPI])
                         ->select(DB::raw('sum(total*100)/sum(count*100.0) as avg'))
                         ->first();
        return $result->avg ?? null;
    }

    public static function forTeam($team){
        $result =  static::where(['relation_id' => $team->id, 'type' => Kpi::TYPE_TEAM, "kpi" => static::KPI])
                         ->select(DB::raw('sum(total*100)/sum(count*100.0) as avg'))
                         ->first();
        return $result->avg ?? null;
    }

    public static function forType($type){
        $result =  static::where(['type' => $type, "kpi" => static::KPI])
                         ->select(DB::raw('sum(total*100)/sum(count*100.0) as avg'))
                         ->first();
        return $result->avg ?? null;
    }
}