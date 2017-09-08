<?php

namespace App\Services\Pop3;

class FakeIncomingMail
{
    public $subject;
    public $fromAddress;
    public $fromName;
    public $textPlain;
    public $id;

    public function __construct($from, $subject, $body)
    {
        $this->fromAddress = $from['email'];
        $this->fromName    = $from['name'];
        $this->subject     = $subject;
        $this->textPlain   = $body;
    }

    public function body()
    {
        return $this->textPlain;
    }

    public function getAttachments()
    {
        return [];
    }
}
