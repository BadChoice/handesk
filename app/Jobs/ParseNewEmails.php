<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Services\Pop3\Mailbox;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\EmailParsers\NewIdeaEmailParser;
use App\Jobs\EmailParsers\NewTicketEmailParser;
use App\Jobs\EmailParsers\NewCommentEmailParser;

class ParseNewEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $messagesParsed = 0;

    protected $handlers = [
      NewIdeaEmailParser::class,
      NewCommentEmailParser::class,
      NewTicketEmailParser::class,
    ];

    public function handle(Mailbox $pop3)
    {
        $pop3->login(config('mail.fetch.host'), config('mail.fetch.port'), config('mail.fetch.username'), config('mail.fetch.password'), 'INBOX', false, config('mail.fetch.options'));
        $pop3->getMessages()->each(function ($message) use ($pop3) {
            $this->processMessage($message);
            $pop3->delete($message->id);
            $this->messagesParsed++;
        });
        $pop3->expunge();
    }

    private function processMessage($message)
    {
        collect($this->handlers)->first(function ($handler) use ($message) {
            return (new $handler)->handle($message);
        });
    }
}
