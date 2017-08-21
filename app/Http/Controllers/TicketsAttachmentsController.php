<?php

namespace App\Http\Controllers;


use App\Attachment;
use App\Lead;
use App\Ticket;
use Illuminate\Support\Facades\Storage;

class TicketsAttachmentsController extends Controller
{
    public function store(Ticket $ticket){
        Attachment::storeAttachmentFromRequest(request(), $ticket);
        return back();
    }
}
