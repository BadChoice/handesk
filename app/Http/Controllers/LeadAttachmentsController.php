<?php

namespace App\Http\Controllers;


use App\Attachment;
use App\Lead;
use Illuminate\Support\Facades\Storage;

class LeadAttachmentsController extends Controller
{
    public function store(Lead $lead){
        Attachment::storeAttachmentFromRequest(request(), $lead);
        return back();
    }
}
