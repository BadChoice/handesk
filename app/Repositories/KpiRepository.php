<?php

namespace App\Repositories;

use App\Kpi\FirstReplyKpi;
use App\Kpi\Kpi;
use App\Kpi\OneTouchResolutionKpi;
use App\Kpi\ReopenedKpi;
use App\Kpi\SolveKpi;
use App\User;

class KpiRepository{
    public function firstReplyKpi( $kpiAgent = null ){
        if( ! $kpiAgent)                    return $this->toTime( FirstReplyKpi::forType( Kpi::TYPE_USER ) );
        if( $kpiAgent instanceof User )     return $this->toTime( FirstReplyKpi::forUser( auth()->user() ) );
        return $this->toTime( FirstReplyKpi::forTeam( $kpiAgent ) );
    }

    public function solveKpi( $kpiAgent = null ){
        if( ! $kpiAgent)                    return $this->toTime( SolveKpi::forType( Kpi::TYPE_USER ) );
        if( $kpiAgent instanceof User )     return $this->toTime( SolveKpi::forUser( auth()->user() ) );
        return $this->toTime( SolveKpi::forTeam( $kpiAgent ) );
    }

    public function oneTouchResolutionKpi( $kpiAgent = null ){
        if( ! $kpiAgent)                    return $this->toPercentage(OneTouchResolutionKpi::forType( Kpi::TYPE_USER ) );
        if( $kpiAgent instanceof User )     return $this->toPercentage(OneTouchResolutionKpi::forUser( auth()->user() ) );
        return $this->toPercentage(OneTouchResolutionKpi::forTeam( $kpiAgent ) );
    }

    public function reopenedKpi( $kpiAgent = null ){
        if( ! $kpiAgent)                    return $this->toPercentage(ReopenedKpi::forType( Kpi::TYPE_USER ), true );
        if( $kpiAgent instanceof User )     return $this->toPercentage(ReopenedKpi::forUser( auth()->user() ), true );
        return $this->toPercentage(ReopenedKpi::forTeam( $kpiAgent ), true );
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