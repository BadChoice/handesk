<?php

namespace App\Http\Controllers\Api;

use App\Requester;
use App\Ticket;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class CommentsController extends ApiController
{
    public function store(Ticket $ticket)
    {
        App::setLocale(request('language'));

        $ticketRequester = Requester::findOrFail($ticket->requester_id);
        try {
            Requester::validateTicketComment(request("requester"), $ticketRequester);
        } catch (\Exception $e) {
            return $this->respond(['id' => null, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

    	$comment = $ticket->addComment(null, strip_tags(request('body')), request('new_status'));

        if (! $comment) {
            return $this->respond(['id' => null, 'message' => __('validation.emptyBodyComment')], Response::HTTP_BAD_REQUEST);
        }

        return $this->respond(['id' => $comment->id, 'message' => __('validation.commentCreated')], Response::HTTP_CREATED);
    }
}
