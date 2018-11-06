<?php

namespace App\Kpi;

use App\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Kpi extends BaseModel
{
    const TYPE_ALL  = 1;
    const TYPE_USER = 2;
    const TYPE_TEAM = 3;

    const KPI_FIRST_REPLY          = 1;
    const KPI_SOLVED               = 2;
    const KPI_ONE_TOUCH_RESOLUTION = 3;
    const KPI_REOPENED             = 4;
    const KPI_UNANSWERED_TICKETS   = 5;
    const KPI_RATING               = 6;

    public $incrementing = false;
    public $timestamps   = false;
    protected $table     = 'kpis';

    const KPI = null;

    protected $startDate;
    protected $endDate;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->startDate = Carbon::today()->startOfMonth();
        $this->endDate   = Carbon::tomorrow();
    }

    public function forDates($start, $end = null)
    {
        $this->startDate = $start;
        $this->endDate   = $end ?: $start->tomorrow();

        return $this;
    }

    public static function obtain(Carbon $date, $relation_id, $type)
    {
        return static::firstOrCreate([
            'date'        => $date->toDateString(),
            'relation_id' => $relation_id,
            'type'        => $type,
            'kpi'         => static::KPI,
        ]);
    }

    public function addValue($value)
    {
        $newTotal = $this->total + $value;

        return static::where([
                'date'        => $this->date,
                'relation_id' => $this->relation_id,
                'type'        => $this->type,
                'kpi'         => $this->kpi,
            ])->update([
                'total' => $newTotal >= 0 ? $newTotal : 0,
                'count' => $this->count + 1,
            ]);
    }

    public function forUser($user)
    {
        $result = static::whereBetween('date', [$this->startDate, $this->endDate])
                          ->where(['relation_id' => $user->id, 'type' => self::TYPE_USER, 'kpi' => static::KPI])
                         ->select(DB::raw('sum(total*100)/sum(count*100.0) as avg'))
                         ->first();

        return $result->avg ?? null;
    }

    public function forTeam($team)
    {
        $result = static::whereBetween('date', [$this->startDate, $this->endDate])
                         ->where(['relation_id' => $team->id, 'type' => self::TYPE_TEAM, 'kpi' => static::KPI])
                         ->select(DB::raw('sum(total*100)/sum(count*100.0) as avg'))
                         ->first();

        return $result->avg ?? null;
    }

    public function forType($type)
    {
        $result = static::whereBetween('date', [$this->startDate, $this->endDate])
                          ->where(['type' => $type, 'kpi' => static::KPI])
                         ->select(DB::raw('sum(total*100)/sum(count*100.0) as avg'))
                         ->first();

        return $result->avg ?? null;
    }
}
