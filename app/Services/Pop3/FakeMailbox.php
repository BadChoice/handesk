<?php

namespace App\Services\Pop3;

class FakeMailbox extends Mailbox
{
    public $messages;

    public function login($host, $port, $user, $pass, $folder = 'INBOX', $ssl = false, $options = null)
    {
    }

    public function getMessages($message = '')
    {
        return collect($this->messages);
    }

    public function delete($mail_id)
    {
        return true;
    }

    public function expunge()
    {
    }
}
