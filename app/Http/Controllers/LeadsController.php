<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Repositories\LeadsIndexQuery;
use App\Repositories\LeadsRepository;

class LeadsController extends Controller
{
    public function index(LeadsRepository $repository)
    {
        $leads = LeadsIndexQuery::get($repository);

        return view('leads.index', ['leads' => $leads->latest()->paginate(25)]);
    }

    public function show(Lead $lead)
    {
        $this->authorize('view', $lead);

        return view('leads.show', ['lead' => $lead]);
    }

    public function update(Lead $lead)
    {
        $lead->update(request()->all());

        return redirect()->route('leads.index');
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'name'  => 'required|min:3',
            'email' => 'nullable|unique:leads',
            'phone' => 'nullable|unique:leads',
        ]);

        $lead = Lead::create(request()->except(['tags', 'team_id']))->attachTags(request('tags'));
        if (request('team_id')) {
            $lead->assignToTeam(request('team_id'));
        }

        return redirect()->route('leads.show', $lead);
    }
}
