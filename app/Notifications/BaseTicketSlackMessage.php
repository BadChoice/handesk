<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\SlackMessage;

class BaseTicketSlackMessage extends SlackMessage
{
    public function __construct($ticket = null, $notifable = null)
    {
        $this->from('Revo Handesk')
             ->image('https://s3-us-west-2.amazonaws.com/slack-files2/avatars/2016-10-05/87744084501_d5ba60de0b67800dbdae_48.png');
        //->to("@jordipuigdellivol");

        $this->overrideToIfChannelOrUser($notifable);

        if ($ticket) {
            $this->attachment(function ($attachment) use ($ticket) {
                $attachment->title($ticket->requester->name.' : '.$ticket->title, route('tickets.show', $ticket))
                            ->content($ticket->body);
            });
        }
    }

    private function overrideToIfChannelOrUser($notifable)
    {
        if (! $notifable) {
            return;
        }
        $route = explode('?', $notifable->routeNotificationForSlack(true));
        if (count($route) < 2) {
            return;
        }
        $slackRoute = $route[1];
        if (starts_with($slackRoute, '#') || starts_with($slackRoute, '@')) {
            $this->to($slackRoute);
        }
    }
}
