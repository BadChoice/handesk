<?php

namespace App\Http\Controllers;


use App\Lead;

class LeadTasksController extends Controller
{
    public function store(Lead $lead){
        $lead->tasks()->create(request()->all());
        return back();
    }
}
