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

    public function show(Lead $lead){
        return view('leads.show', ["lead" => $lead]);
    }

    public function update(Lead $lead){
        $lead->update( request()->all() );
        return redirect()->route('leads.index');
    }
}
