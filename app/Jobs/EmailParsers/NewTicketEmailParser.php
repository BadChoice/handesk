<?php

namespace App\Jobs\EmailParsers;

use App\Ticket;
use App\Attachment;

class NewTicketEmailParser
{
    public function handle($message)
    {
        $ticket = Ticket::createAndNotify(['name' => $message->fromName, 'email' => $message->fromAddress], $message->subject, $message->body(), ['email'], 1);
        Attachment::storeAttachmentsFromEmail($message, $ticket);

        return true;
    }
}
