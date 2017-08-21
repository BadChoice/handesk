<?php

namespace App\Jobs;

use App\Attachment;
use App\Services\Pop3\Mailbox;
use App\Services\Pop3\IncomingMailCommentParser;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class CreateTicketsFromNewEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $newComments = 0;
    public $newTickets  = 0;

    public function handle(Mailbox $pop3) {
        $pop3->login( config('mail.fetch.host'), config('mail.fetch.port'), config('mail.fetch.username'), config('mail.fetch.password') );
        $pop3->getMessages()->each(function($message) use($pop3){
            $this->processMessage($message);
            $pop3->delete($message->id);
        });
        $pop3->expunge();
    }

    private function processMessage($message){
        if( $this->addCommentFromMessage( $message ) ) return;
        $ticket = Ticket::createAndNotify(["name" => $message->fromName, "email" => $message->fromAddress], $message->subject, $message->textPlain, ["email"]);
        Attachment::storeAttachmentsFromEmail($message, $ticket);
        $this->newTickets = $this->newTickets + 1;
    }

    private function addCommentFromMessage( $message ){
        $messageParser  = new IncomingMailCommentParser($message);
        $ticket         = $messageParser->checkIfItIsACommentAndGetTheTicket();
        if( ! $ticket ) return false;
        $comment = $ticket->addComment( $messageParser->getUser( $ticket ),
                             $messageParser->getCommentBody() );
        Attachment::storeAttachmentsFromEmail($message, $comment);
        $this->newComments = $this->newComments + 1;
        return true;
    }
}
