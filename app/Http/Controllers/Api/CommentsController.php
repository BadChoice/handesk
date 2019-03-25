<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Response;
use App\Events\ApiNotificationEvent;

class CommentsController extends ApiController
{
    public function store(Ticket $ticket)
    {
        $comment = $ticket->addComment(null, request('body'), request('new_status'));
        if (! $comment) {
            $this->respond(['id' => null, 'message' => 'Can not create a comment with empty body'], Response::HTTP_OK);
        }
        \Log::info('here');

        $data = ['title' => 'user has been comment'];
        $data['data'] = json_encode($ticket);
        $data['comment'] = $comment;
        $data['type'] = 'comment';
        event(new ApiNotificationEvent($data));
        return $this->respond(['id' => $comment->id], Response::HTTP_CREATED);
    }
}