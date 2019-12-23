<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Lead;

class LeadStatusController extends Controller
{
    public function store(Lead $lead)
    {
        $this->authorize('view', $lead);
        $leadStatus = $lead->updateStatus(auth()->user(), request('body'), request('new_status'));
        if (request()->hasFile('attachment')) {
            Attachment::storeAttachmentFromRequest(request(), $leadStatus);
        }

        return redirect()->route('leads.index');
    }
}
