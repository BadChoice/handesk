<?php

namespace App\Http\Controllers;

use App\Lead;

class LeadStatusController extends Controller
{
    public function store(Lead $lead) {
        $this->authorize('view', $lead);
        $lead->updateStatus(auth()->user(), request('body'), request('new_status') );
        return redirect()->route('leads.index');
    }
}
