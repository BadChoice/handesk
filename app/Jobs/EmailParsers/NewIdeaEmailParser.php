<?php

namespace App\Jobs\EmailParsers;

use App\Idea;

class NewIdeaEmailParser
{
    public function handle($message)
    {
        if (! starts_with(strtolower($message->subject), 'idea:')) {
            return false;
        }
        $subject = ucfirst(trim(str_after(strtolower($message->subject), 'idea:')));
        Idea::createAndNotify(['name' => $message->fromName, 'email' => $message->fromAddress], $subject, $message->body(), null, ['email']);

        return true;
    }
}
