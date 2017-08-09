<?php

namespace App\Services\Pop3;

class Pop3{

    protected $connection;

    function login($host, $port, $user, $pass, $folder = "INBOX", $ssl = false) {
        $ssl = ($ssl == false) ? "/novalidate-cert" : "";
        $this->connection = (imap_open("{" . "$host:$port/pop3$ssl" . "}$folder", $user, $pass));
        return $this;
    }

    function stat() {
        $check = imap_mailboxmsginfo($this->connection);
        return ((array)$check);
    }

    function getMessages($message = "") {
        if ($message) {
            $range = $message;
        } else {
            $MC = imap_check($this->connection);
            $range = "1:" . $MC->Nmsgs;
        }
        $response = imap_fetch_overview($this->connection, $range);
        return collect($response)->map(function ($msg) {
            return new Pop3Message($this->connection, $msg);
        });
    }

    public function expunge(){
        imap_expunge($this->connection);
    }
}

?>