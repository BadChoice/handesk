<?php

namespace App\Jobs\EmailParsers;

use App\Attachment;
use App\Ticket;

class NewTicketEmailParser
{
    public function handle($message)
    {
        $ticket = Ticket::createAndNotify(['name' => $message->fromName, 'email' => $message->fromAddress], $message->subject, $message->body(), ['email']);
        Attachment::storeAttachmentsFromEmail($message, $ticket);

        return true;
    }
}
