<?php

namespace App\Services\Pop3;

class FakePop3 extends Pop3{

    public $messages;

    public function login($host, $port, $user, $pass, $folder = "INBOX", $ssl = false) {

    }

    function getMessages($message = "") {
        return collect($this->messages);
    }

    public function expunge(){
        return;
    }
}