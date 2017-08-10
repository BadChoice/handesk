<?php

namespace App\Repositories;

use App\Kpi\FirstReplyKpi;
use App\Kpi\Kpi;
use App\Kpi\OneTouchResolutionKpi;
use App\Kpi\ReopenedKpi;
use App\Kpi\SolveKpi;
use App\Ticket;
use App\User;

class KpiRepository{

    public function tickets($agent = null){
        if(! $agent) return Ticket::count();
        if( $agent instanceof User )     return Ticket::where(["user_id" => $agent->id])->count();
        return Ticket::where(["team_id" => $agent->id])->count();
    }

    public function firstReplyKpi( $agent = null ){
        if( ! $agent)                    return $this->toTime( FirstReplyKpi::forType( Kpi::TYPE_USER ) );
        if( $agent instanceof User )     return $this->toTime( FirstReplyKpi::forUser( auth()->user() ) );
        return $this->toTime( FirstReplyKpi::forTeam( $agent ) );
    }

    public function solveKpi( $agent = null ){
        if( ! $agent)                    return $this->toTime( SolveKpi::forType( Kpi::TYPE_USER ) );
        if( $agent instanceof User )     return $this->toTime( SolveKpi::forUser( auth()->user() ) );
        return $this->toTime( SolveKpi::forTeam( $agent ) );
    }

    public function oneTouchResolutionKpi( $agent = null ){
        if( ! $agent)                    return $this->toPercentage(OneTouchResolutionKpi::forType( Kpi::TYPE_USER ) );
        if( $agent instanceof User )     return $this->toPercentage(OneTouchResolutionKpi::forUser( auth()->user() ) );
        return $this->toPercentage(OneTouchResolutionKpi::forTeam( $agent ) );
    }

    public function reopenedKpi( $agent = null ){
        if( ! $agent)                    return $this->toPercentage(ReopenedKpi::forType( Kpi::TYPE_USER ), true );
        if( $agent instanceof User )     return $this->toPercentage(ReopenedKpi::forUser( auth()->user() ), true );
        return $this->toPercentage(ReopenedKpi::forTeam( $agent ), true );
    }

    public function average($kpi, $agent){
        if($kpi == Kpi::KPI_FIRST_REPLY) {
            $agentValue = $this->firstReplyKpi($agent);
            $overallValue = $this->firstReplyKpi();
        }
        else if($kpi == Kpi::KPI_SOLVED){
            $agentValue = $this->solveKpi($agent);
            $overallValue = $this->solveKpi();
        }
        else if($kpi == Kpi::KPI_ONE_TOUCH_RESOLUTION){
            $agentValue = $this->oneTouchResolutionKpi($agent);
            $overallValue = $this->oneTouchResolutionKpi();
        }
        else if($kpi == Kpi::KPI_REOPENED){
            $agentValue     = $this->reopenedKpi($agent);
            $overallValue   = $this->reopenedKpi();
        }
        else{
            $agentValue     = $this->tickets($agent);
            $overallValue   = $this->tickets();
        }
        return $this->toPercentage(  - 1 + ($agentValue / $overallValue) );
    }

    private function toTime($minutes){
        $days = floor ($minutes / 1440);
        $hours = floor (($minutes - $days * 1440) / 60);
        $mins = $minutes - ($days * 1440) - ($hours * 60);
        return "{$days} days {$hours} hours {$mins} minutes";
    }

    private function toPercentage($value, $inverse = false){
        if($inverse) return (1 - $value) * 100 . " %";
        return $value * 100 . " %";
    }
}