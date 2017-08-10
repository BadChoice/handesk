<?php

namespace App\Services\Pop3;

use App\Ticket;
use App\User;

class Pop3MessageCommentParser{

    public $message;

    public function __construct($message){
        $this->message = $message;
    }

    public function checkIfItIsACommentAndGetTheTicket(){
        if (! $this->isAComment( ) ) return null;
        return Ticket::find( $this->getTicketId() );
    }

    public function isAComment(){
        return str_contains($this->message->body(), ":: Reply above this line ::");
    }

    public function getCommentBody(){
        return strstr($this->message->body(), ":: Reply above this line ::", true);
    }

    public function getTicketId() {
        preg_match('~ticket-id:(\d+)(\.)~', $this->message->body(), $results );
        return  (count($results) > 1) ? $results[1] : null;
    }

    public function getUser($ticket){
        $fromEmail = $this->message->from()["email"];
        if($fromEmail == $ticket->requester->email) return null;
        return User::where("email", $fromEmail)->first();
    }
}