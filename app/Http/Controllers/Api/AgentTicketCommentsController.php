<?php

namespace App\Http\Controllers\Api;

use App\Attachment;
use App\Ticket;
use Illuminate\Http\Response;
use Auth;
use Validator;

class AgentTicketCommentsController extends ApiController
{
    public function index(Ticket $ticket)
    {
        if (! auth()->user()->can('view', $ticket)) {
            return $this->respondError("You don't have access to this ticket");
        }

        return $this->respond($ticket->commentsAndNotes);
    }

    public function ticketAll() {
        $user = Auth::user();
        if(!$user) return $this->respondError("Agent Not Found");

        $tickets = $user->tickets;

        if (request('status') == 'new') {
            $tickets = $user->newTickets;
        } 
        if (request('status') == 'open') {
            $tickets = $user->openTickets;
        }
        if (request('status') == 'end') {
            $tickets = $user->closedTickets;
        }

        return $this->respond($tickets);
    }

    public function detail($id)
    {
        $ticket = Ticket::find($id);
        if(!$ticket) return $this->respondError("Ticket Not Found");

        return $this->respond($ticket);
    }

    public function startTask($id)
    {
        $ticket = Ticket::find($id);
        if(!$ticket) return $this->respondError("Ticket Not Found");

        $ticket->status = '2';
        $ticket->save();

        return $this->respond($ticket);

    }

    public function report($ticketId)
    {
        $user = auth()->user();

        $ticket = Ticket::where('id', $ticketId)->select('id')->first();

        if (!$ticket) {
            return $this->respondError("Ticket tidak ditemukan");
        }
        
        /**
         * FIXME: Sorry temporer comment
         */
        /*
        if (!$user->can('update', $ticket)) {
            return $this->respondError("Anda tidak memiliki akses ke tiket ini");
        }
        */
        
        $validator = Validator::make(request()->all(), [
            'body' => 'required'
        ], [
            'required' => ':attribute wajib diisi'
        ]);
        
        if($validator->fails()){
            $errors = $validator->errors();
            return $this->respondError($errors->first());
        }

        if (request('private')) {
            $comment = $ticket->addNote($user, request('body'));
        } else {
            $comment = $ticket->addComment($user, request('body'), request('new_status', Ticket::STATUS_SOLVED));
        }

        if (request()->hasFile('attachment')) {
            Attachment::storeAttachmentFromRequest(request(), $comment);
        }

        return $this->respond([
            'body'       => $comment->body,
            'new_status' => $comment->new_status,
            'created_at' => $comment->created_at,
            'author'     => $comment->author
        ], Response::HTTP_CREATED);
    }

    public function getCommentByTask($taskId)
    {
        $ticket = Ticket::where('id', $taskId)->select('id')->first();

        if(!$ticket){
            return $this->respondError("Tiket / Tugas tidak ditemukan");
        }

        $comments = count($ticket->comments) <= 0 ? [] : $ticket->comments->map(function($item){
            return array(
                'id' => $item->id,
                'body' => $item->body,
                'created_at' => $item->created_at,
                'attachments' => count($item->attachments) <= 0 ? [] : $item->attachments->map(function($file){
                    return array(
                        'id' => $file->id,
                        'url' => \Storage::disk(config('filesystems.default'))->url("public/attachments/$file->path")
                    );
                })
            );
        });

        return $this->respond($comments, Response::HTTP_OK);
    }
}
