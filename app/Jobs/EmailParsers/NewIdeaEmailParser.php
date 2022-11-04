<?php

namespace App\Jobs\EmailParsers;

use App\Idea;
use Illuminate\Support\Str;

class NewIdeaEmailParser
{
    public function handle($message)
    {
        if (! Str::startsWith(strtolower($message->subject), 'idea:')) {
            return false;
        }
        $subject = ucfirst(trim(Str::after(strtolower($message->subject), 'idea:')));
        Idea::createAndNotify(['name' => $message->fromName, 'email' => $message->fromAddress], $subject, $message->body(), null, ['email']);

        return true;
    }
}
