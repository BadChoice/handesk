<?php

namespace App\Http\Controllers;

use App\Lead;

class LeadsController extends Controller
{
    public function index(){
        if(auth()->user()->admin) $leads = Lead::query();
        else                      $leads = auth()->user()->teamsLeads();
        return view('leads.index', [ "leads" => $leads->paginate(25) ]);
    }
}
