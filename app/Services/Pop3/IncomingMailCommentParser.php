<?php

namespace App\Services\Pop3;

use App\User;
use App\Ticket;

class IncomingMailCommentParser
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function checkIfItIsACommentAndGetTheTicket()
    {
        if (! $this->isAComment()) {
            return;
        }

        return Ticket::find($this->getTicketId());
    }

    public function isAComment()
    {
        return str_contains($this->message->body(), config('mail.fetch.replyAboveLine'));
    }

    public function getCommentBody()
    {
        return strstr($this->message->body(), config('mail.fetch.replyAboveLine'), true);
    }

    public function getTicketId()
    {
        preg_match('~ticket-id:(\d+)(\.)~', $this->message->body(), $results);

        return  (count($results) > 1) ? $results[1] : null;
    }

    public function getUser($ticket)
    {
        $fromEmail = $this->message->fromAddress;
        if ($fromEmail === $ticket->requester->email) {
            return;
        }

        return User::where('email', $fromEmail)->first();
    }
}
