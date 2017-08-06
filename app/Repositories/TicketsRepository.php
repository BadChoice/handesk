<?php

namespace App\Repositories;

use App\Ticket;

class TicketsRepository{

    public function assignedToMe(){
        return auth()->user()->tickets()->where('status','<',Ticket::STATUS_CLOSED);
    }

    public function unassigned(){
        if( auth()->user()->admin )
            return Ticket::whereNull('user_id')->where('status','<',Ticket::STATUS_CLOSED);
        return auth()->user()->teamsTickets()->whereRaw('tickets.user_id is NULL')->where('status','<',Ticket::STATUS_CLOSED);
    }

    public function all(){
        if( auth()->user()->admin ){
            return Ticket::where('status','<',Ticket::STATUS_CLOSED);
        }
        return auth()->user()->teamsTickets()->where('status','<',Ticket::STATUS_CLOSED);
    }

    public function closed(){
        if( auth()->user()->admin ){
            return Ticket::where('status','=',Ticket::STATUS_CLOSED);
        }
        return auth()->user()->teamsTickets()->where('status','=',Ticket::STATUS_CLOSED);
    }
}