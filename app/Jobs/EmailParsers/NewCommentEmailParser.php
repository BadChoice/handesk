<?php

namespace App\Jobs\EmailParsers;

use App\Attachment;
use App\Services\Pop3\IncomingMailCommentParser;

class NewCommentEmailParser
{
    public function handle($message)
    {
        $messageParser = new IncomingMailCommentParser($message);
        $ticket        = $messageParser->checkIfItIsACommentAndGetTheTicket();
        if (! $ticket) {
            return false;
        }
        $comment = $ticket->addComment(
            $messageParser->getUser($ticket),
            $messageParser->getCommentBody()
        );
        Attachment::storeAttachmentsFromEmail($message, $comment);

        return true;
    }
}
