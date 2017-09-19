<?php

namespace App\Http\Controllers;

use App\Lead;

class LeadAssignController extends Controller
{
    public function store(Lead $lead)
    {
        if (request('team_id')) {
            $this->authorize('assignToTeam', $lead);
            $lead->assignToTeam(request('team_id'));
        }
        if (request('user_id')) {
            $lead->assignTo(request('user_id'));
        }

        return redirect()->route('leads.index');
    }
}
