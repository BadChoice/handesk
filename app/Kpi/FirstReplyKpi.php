<?php

namespace App\Kpi;


use Illuminate\Support\Facades\DB;

class FirstReplyKpi extends Kpi
{
    public static function forUser($user){
        return static::where(['relation_id' => $user->id, 'type' => Kpi::TYPE_USER])
                        ->select(DB::raw('avg(avg) as avg'))
                        ->first()->avg ;
    }
}
