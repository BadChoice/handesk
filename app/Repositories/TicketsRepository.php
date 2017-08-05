<?php

namespace App\Repositories;

use App\Ticket;

class TicketsRepository{

    public function assignedToMe(){
        return auth()->user()->tickets;
    }

    public function unassigned(){
        if( auth()->user()->admin )
            return Ticket::whereNull('user_id')->get();
        return auth()->user()->teamsTickets->where('user_id',null);
    }

    public function all(){
        if( auth()->user()->admin ){
            return Ticket::all();
        }
        return auth()->user()->teamsTickets;
    }

}