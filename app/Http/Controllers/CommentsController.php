<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Attachment;
use GuzzleHttp\Client;

class CommentsController extends Controller
{
    public function store(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        if (request('private')) {
            $comment = $ticket->addNote(auth()->user(), request('body'));
        } else {
            $comment = $ticket->addComment(auth()->user(), request('body'), request('new_status'));
        }
        if ($comment && request()->hasFile('attachment')) {
            Attachment::storeAttachmentFromRequest(request(), $comment);
        }
        $ticket->user;
        $ticket->requester;
        $message = ['title'=>auth()->user()->name.' has been comment','content'=>request('body')];
        $this->notificationToolBox($ticket, $message);
        return redirect()->route('tickets.index');
    }

    protected function notificationToolBox($data, $message = [])
    {
        try {
            $client = new Client();
            $api_url = getenv('NOTIFICATION_API');
            $api_token = getenv('NOTIFICATION_API_TOKEN');
            $response = $client->get($api_url, [
                'headers' => [
                    'Authorization' => 'Bearer '.$api_token
                ],
                'query'=>[
                  'type'=>'comment',
                  'title'=>$message['title'],
                  'content'=>$message['content'],
                  'data'=>json_encode($data)
                ]
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
