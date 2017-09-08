<?php

namespace App\Repositories;

use App\Kpi\FirstReplyKpi;
use App\Kpi\Kpi;
use App\Kpi\OneTouchResolutionKpi;
use App\Kpi\ReopenedKpi;
use App\Kpi\SolveKpi;
use App\Ticket;
use App\User;
use Carbon\Carbon;

class KpiRepository{
    public $startDate;
    public $endDate;

    public function __construct($startDate = null, $endDate = null){
        $this->startDate    = $startDate ? : Carbon::today()->firstOfMonth() ;
        $this->endDate      = $endDate   ? : Carbon::tomorrow() ;
    }

    public function forDates($start, $end){
        $this->startDate    = $start;
        $this->endDate      = $end;
        return $this;
    }

    private function ticketsQuery($agent = null){
        if(! $agent)                        $q = Ticket::query();
        else if( $agent instanceof User )   $q = Ticket::where(["user_id" => $agent->id]);
        else                                $q = Ticket::where(["team_id" => $agent->id]);
        return $q->whereBetween('created_at',[$this->startDate,$this->endDate]);
    }

    public function tickets($agent = null){
        return $this->ticketsQuery($agent)->count();
    }

    public function unansweredTickets($agent = null){
        return $this->ticketsQuery($agent)->open()->whereDoesntHave('comments')->count();
    }

    public function openTickets($agent = null){
        return $this->ticketsQuery($agent)->open()->count();
    }

    public function solvedTickets($agent = null){
        return $this->ticketsQuery($agent)->solved()->count();
    }

    public function firstReplyKpi( $agent = null ){
        return $this->timeKpi(FirstReplyKpi::class, $agent);
    }

    public function solveKpi( $agent = null ){
        return $this->timeKpi(SolveKpi::class, $agent);
    }

    public function oneTouchResolutionKpi( $agent = null ){
        return $this->percentageKpi(OneTouchResolutionKpi::class, $agent, false);
    }

    public function reopenedKpi( $agent = null ){
        return $this->percentageKpi(ReopenedKpi::class, $agent, true);
    }

    public function percentageKpi($kpiClass, $agent = null, $inverse = false){
        $kpi = (new $kpiClass)->forDates($this->startDate, $this->endDate);
        if( ! $agent)                       return $this->toPercentage($kpi->forType( Kpi::TYPE_USER ), $inverse );
        if( $agent instanceof User )        return $this->toPercentage($kpi->forUser( auth()->user() ), $inverse );
                                            return $this->toPercentage($kpi->forTeam( $agent ), $inverse );
    }

    public function timeKpi($kpiClass, $agent = null){
        $kpi = (new $kpiClass)->forDates($this->startDate, $this->endDate);
        if( ! $agent)                       return $this->toTime( $kpi->forType( Kpi::TYPE_USER ) );
        if( $agent instanceof User )        return $this->toTime( $kpi->forUser( auth()->user() ) );
                                            return $this->toTime( $kpi->forTeam( $agent ) );
    }

    public function average($kpi, $agent){
        if($kpi == Kpi::KPI_FIRST_REPLY) {
            $agentValue     = $this->firstReplyKpi($agent);
            $overallValue   = $this->firstReplyKpi();
        }
        else if($kpi == Kpi::KPI_SOLVED){
            $agentValue     = $this->solveKpi($agent);
            $overallValue   = $this->solveKpi();
        }
        else if($kpi == Kpi::KPI_ONE_TOUCH_RESOLUTION){
            $agentValue     = $this->oneTouchResolutionKpi($agent);
            $overallValue   = $this->oneTouchResolutionKpi();
        }
        else if($kpi == Kpi::KPI_REOPENED){
            $agentValue     = $this->reopenedKpi($agent);
            $overallValue   = $this->reopenedKpi();
        }
        else if($kpi == Kpi::KPI_UNANSWERED_TICKETS){
            $agentValue     = $this->unansweredTickets($agent);
            $overallValue   = $this->unansweredTickets();
        }
        else{
            $agentValue     = $this->tickets($agent);
            $overallValue   = $this->tickets();
        }
        if($overallValue == 0) return 0;
        return $this->toPercentage(  - 1 + ($agentValue / $overallValue) );
    }

    private function toTime($minutes){
        $days   = floor ($minutes / 1440);
        $hours  = floor (($minutes - $days * 1440) / 60);
        $mins   = (int)($minutes - ($days * 1440) - ($hours * 60));
        return "{$days} Days {$hours} Hours {$mins} Mins";
    }

    private function toPercentage($value, $inverse = false){
        return  ($inverse ? 1 - $value : $value)* 100 ;
    }
}