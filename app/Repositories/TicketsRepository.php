<?php

namespace App\Repositories;

use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TicketsRepository{

    public function escalated(){
        if( auth()->user()->assistant )
            return Ticket::whereLevel(1)->where('status','<',Ticket::STATUS_SOLVED);
        return Ticket::whereStatus(100);
    }

    public function assignedToMe(){
        return auth()->user()->tickets()->where('status','<',Ticket::STATUS_SOLVED);
    }

    public function unassigned(){
        if( auth()->user()->admin )
            return Ticket::whereNull('user_id')->where('status','<',Ticket::STATUS_SOLVED);
        return auth()->user()->teamsTickets()->whereRaw('tickets.user_id is NULL')->where('status','<',Ticket::STATUS_SOLVED);
    }

    public function all(){
        if( auth()->user()->admin ){
            return Ticket::where('status','<',Ticket::STATUS_SOLVED);
        }
        return auth()->user()->teamsTickets()->where('status','<',Ticket::STATUS_SOLVED);
    }

    public function recentlyUpdated(){
        return $this->all()->whereRaw("tickets.updated_at > '" . Carbon::parse("-1 days")->toDateTimeString() ."'" );
    }

    public function solved(){
        if( auth()->user()->admin ){
            return Ticket::where('status','=',Ticket::STATUS_SOLVED);
        }
        return auth()->user()->teamsTickets()->where('status','=',Ticket::STATUS_SOLVED);
    }

    public function closed(){
        if( auth()->user()->admin ){
            return Ticket::where('status','=',Ticket::STATUS_CLOSED);
        }
        return auth()->user()->teamsTickets()->where('status','=',Ticket::STATUS_CLOSED);
    }

    public function search($text){
        if( auth()->user()->admin ){
            $leadsQuery = Ticket::query();
        } else {
            $leadsQuery = auth()->user()->teamsTickets();
        }
        return $leadsQuery->where('title','like',"%$text%")->orWhere('body','like',"%$text%");
    }
}