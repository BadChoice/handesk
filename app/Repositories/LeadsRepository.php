<?php

namespace App\Repositories;

use App\Lead;
use Carbon\Carbon;

class LeadsRepository{

    public function assignedToMe(){
        return auth()->user()->leads()->where('status','<',Lead::STATUS_COMPLETED);
    }

    public function unassigned(){
        if( auth()->user()->admin )
            return Lead::whereNull('user_id')->where('status','<',Lead::STATUS_COMPLETED);
        return auth()->user()->teamsLeads()->whereRaw('tickets.user_id is NULL')->where('status','<',Lead::STATUS_COMPLETED);
    }

    public function all(){
        if( auth()->user()->admin ){
            return Lead::where('status','<',Lead::STATUS_COMPLETED);
        }
        return auth()->user()->teamsLeads()->where('status','<',Lead::STATUS_COMPLETED);
    }

    public function recentlyUpdated(){
        return $this->all()->whereRaw("leads.updated_at > '" . Carbon::parse("-1 days")->toDateTimeString() ."'" );
    }

    public function completed(){
        if( auth()->user()->admin ){
            return Lead::where('status','=',Lead::STATUS_COMPLETED);
        }
        return auth()->user()->teamsLeads()->where('status','=',Lead::STATUS_COMPLETED);
    }

    public function failed(){
        if( auth()->user()->admin ){
            return Lead::where('status','=',Lead::STATUS_FAILED);
        }
        return auth()->user()->teamsLeads()->where('status','=',Lead::STATUS_FAILED);
    }
}