<?php

namespace App\Repositories;

use App\Kpi\FirstReplyKpi;
use App\Kpi\Kpi;
use App\Kpi\OneTouchResolutionKpi;
use App\Kpi\RatedKpi;
use App\Kpi\ReopenedKpi;
use App\Kpi\SolveKpi;
use App\Team;
use App\Ticket;
use App\User;
use Carbon\Carbon;

class KpiRepository
{
    public $startDate;
    public $endDate;

    protected $kpiFunctions = [
        Kpi::KPI_FIRST_REPLY          => 'firstReplyKpi',
        Kpi::KPI_SOLVED               => 'solveKpi',
        Kpi::KPI_ONE_TOUCH_RESOLUTION => 'oneTouchResolutionKpi',
        Kpi::KPI_REOPENED             => 'reopenedKpi',
        Kpi::KPI_UNANSWERED_TICKETS   => 'unansweredTickets',
        Kpi::KPI_RATING               => 'ratingKpi',
    ];

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate ?: Carbon::today()->firstOfMonth();
        $this->endDate   = $endDate ?: Carbon::tomorrow();
    }

    public function forDates($start, $end)
    {
        $this->startDate = $start;
        $this->endDate   = $end;

        return $this;
    }

    public function tickets($agent = null)
    {
        return $this->ticketsQuery($agent)->count();
    }

    public function unansweredTickets($agent = null)
    {
        return $this->ticketsQuery($agent)->open()->whereDoesntHave('comments')->count();
    }

    public function openTickets($agent = null)
    {
        return $this->ticketsQuery($agent)->open()->count();
    }

    public function solvedTickets($agent = null)
    {
        return $this->ticketsQuery($agent)->solved()->count();
    }

    public function firstReplyKpi($agent = null)
    {
        return $this->timeKpi(FirstReplyKpi::class, $agent);
    }

    public function solveKpi($agent = null)
    {
        return $this->timeKpi(SolveKpi::class, $agent);
    }

    public function oneTouchResolutionKpi($agent = null)
    {
        return $this->percentageKpi(OneTouchResolutionKpi::class, $agent, false);
    }

    public function reopenedKpi($agent = null)
    {
        return $this->percentageKpi(ReopenedKpi::class, $agent, true);
    }

    public function averageRating($agent = null)
    {
        return number_format($this->kpiAverage(RatedKpi::class, $agent), 2);
    }

    public function average($kpi, $agent)
    {
        extract($this->getAverageValues($this->kpiFunctions[$kpi], $agent));

        return ($overallValue == 0) ? 0 : toPercentage(-1 + ($agentValue / $overallValue));
    }

    protected function getAverageValues($functionName, $agent)
    {
        return [
            'agentValue'   => $this->$functionName($agent),
            'overallValue' => $this->$functionName(),
        ];
    }

    protected function ticketsQuery($agent = null)
    {
        $query = Ticket::query();
        if ($agent instanceof User) {
            $query = $query->where(['user_id' => $agent->id]);
        }
        if ($agent instanceof Team) {
            $query = $query->where(['team_id' => $agent->id]);
        }

        return $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    protected function percentageKpi($kpiClass, $agent = null, $inverse = false)
    {
        $kpi = (new $kpiClass)->forDates($this->startDate, $this->endDate);
        if (! $agent) {
            return toPercentage($kpi->forType(Kpi::TYPE_USER), $inverse);
        }
        if ($agent instanceof User) {
            return toPercentage($kpi->forUser(auth()->user()), $inverse);
        }

        return toPercentage($kpi->forTeam($agent), $inverse);
    }

    protected function timeKpi($kpiClass, $agent = null)
    {
        $kpi = (new $kpiClass)->forDates($this->startDate, $this->endDate);
        if (! $agent) {
            return toTime($kpi->forType(Kpi::TYPE_USER));
        }
        if ($agent instanceof User) {
            return toTime($kpi->forUser(auth()->user()));
        }

        return toTime($kpi->forTeam($agent));
    }

    public function kpiAverage($kpi, $agent)
    {
        $kpi = (new RatedKpi)->forDates($this->startDate, $this->endDate);
        if (! $agent) {
            return $kpi->forType(Kpi::TYPE_USER);
        }
        if ($agent instanceof User) {
            return $kpi->forUser(auth()->user());
        }

        return $kpi->forTeam($agent);
    }
}
