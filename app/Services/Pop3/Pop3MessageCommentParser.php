<?php

namespace App\Services\Pop3;

class Pop3MessageCommentParser{

    protected $message;

    public function __construct($message){
        $this->message = $message;
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
}