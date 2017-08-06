<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\SlackMessage;

class BaseSlackMessage extends SlackMessage{

    public function __construct() {
        $this->from('Revo Handesk')
        ->image('https://s3-us-west-2.amazonaws.com/slack-files2/avatars/2016-10-05/87744084501_d5ba60de0b67800dbdae_48.png')
        ->to("@jordipuigdellivol");
    }
}