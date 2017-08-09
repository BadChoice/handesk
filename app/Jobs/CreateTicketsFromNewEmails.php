<?php

namespace App\Jobs;

use App\Services\Pop3\Pop3;
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
           Ticket::createAndNotify($message->from(), $message->subject(), $message->body(), ["email"]);
           $message->delete();
        });
        $pop3->expunge();
    }
}
