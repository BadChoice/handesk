<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Ticket;
use DB;

class CommentsController extends Controller
{
    public function store(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        DB::beginTransaction();
        try {
            if (request('private')) {
                $comment = $ticket->addNote(auth()->user(), request('body'));
            } else {
                $comment = $ticket->addComment(auth()->user(), request('body'), request('new_status'));
            }
    
            if ($comment && request()->hasFile('attachments')) {
                foreach (request('attachments') as $key => $value) {
                    Attachment::storeAttachmentFromFile($value, $comment);
                }
            }
    
            DB::commit();
            return redirect()->route('tickets.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
