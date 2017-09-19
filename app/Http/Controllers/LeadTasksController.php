<?php

namespace App\Http\Controllers;

use App\Lead;

class LeadTasksController extends Controller
{
    public function index(Lead $lead)
    {
        return view('leads.tasks.index', ['lead' => $lead]);
    }

    public function store(Lead $lead)
    {
        $lead->tasks()->create(['user_id' => auth()->user()->id] + request()->all());

        return back();
    }
}
