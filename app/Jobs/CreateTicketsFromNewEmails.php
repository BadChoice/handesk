<?php

namespace App\Jobs;

use App\Services\Pop3\Pop3;
use App\Services\Pop3\Pop3MessageCommentParser;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateTicketsFromNewEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(Pop3 $pop3) {
        $pop3->login( config('mail.fetch.host'), config('mail.fetch.port'), config('mail.fetch.username'), config('mail.fetch.password') );
        $pop3->getMessages()->each(function($message){
            $this->processMessage($message);
            $message->delete();
        });
        $pop3->expunge();
    }

    private function processMessage($message){
        $messageParser = new Pop3MessageCommentParser($message);
        if( $messageParser->isAComment( ) ){
            return $this->addCommentFromMessage( $messageParser );
        }
        Ticket::createAndNotify($message->from(), $message->subject(), $message->body(), ["email"]);
    }

    private function addCommentFromMessage( $messageParser ){
        $ticketId = $messageParser->getTicketId();
        if ( ! $ticketId) return;
        Ticket::find( $ticketId )->addComment(null, $messageParser->getCommentBody() );
    }
}
