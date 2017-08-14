<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Repositories\LeadsRepository;

class LeadsController extends Controller
{
    public function index(LeadsRepository $repository){
        if(request('mine'))             { $leads = $repository->assignedToMe(); }
        else if(request('completed'))   { $leads = $repository->completed(); }
        else if(request('failed'))      { $leads = $repository->failed(); }
        else $leads = $repository->all();

        if( request('team'))                $leads = $leads->where('leads.team_id', request('team'));

        return view('leads.index', [ "leads" => $leads->paginate(25) ]);
    }

    public function show(Lead $lead){
        return view('leads.show', ["lead" => $lead]);
    }

    public function update(Lead $lead){
        $lead->update( request()->all() );
        return redirect()->route('leads.index');
    }

    public function create(){
        return view('leads.create');
    }

    public function store(){
        $lead = Lead::create( request()->except(['tags','team_id']) )->attachTags(request('tags'));
        if(request('team_id')){
            $lead->assignToTeam( request('team_id'));
        }
        return redirect()->route('leads.show',$lead);
    }

}
