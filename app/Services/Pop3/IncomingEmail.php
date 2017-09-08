<?php

namespace App\Services\Pop3;

class IncomingEmail
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function body()
    {
        if (empty($this->email->textPlain)) {
            return strip_tags($this->email->textHtml, '<p><a>');
        }

        return $this->email->textPlain;
    }

    public function getAttachments()
    {
        return $this->email->getAttachments();
    }

    public function __get($value)
    {
        return $this->email->$value;
    }
}
