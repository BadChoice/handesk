<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\SlackMessage;

class BaseTicketSlackMessage extends SlackMessage{

    public function __construct($ticket = null) {
        $this->from('Revo Handesk')
             ->image('https://s3-us-west-2.amazonaws.com/slack-files2/avatars/2016-10-05/87744084501_d5ba60de0b67800dbdae_48.png')
             ->to("@jordipuigdellivol");
        if($ticket){
            $this->attachment(function ($attachment) use($ticket) {
                $attachment->title($ticket->requester->name . " : " . $ticket->title, route("tickets.show", $ticket))
                            ->content($ticket->body);
            });
        }
    }
}