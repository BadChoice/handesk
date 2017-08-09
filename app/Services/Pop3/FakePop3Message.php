<?php

namespace App\Services\Pop3;

class FakePop3Message{
    public $subject;
    public $from;
    public $body;

    public function __construct($from, $subject, $body) {
        $this->from     = $from;
        $this->subject  = $subject;
        $this->body     = $body;
    }

    public function subject(){
        return $this->subject;
    }

    public function from(){
        return $this->from;
    }

    public function body(){
        return $this->body;
    }
    public function delete(){
        return true;
    }
}