<?php

namespace App\Services\Pop3;

class Mailbox
{
    /** @var \PhpImap\Mailbox mailbox */
    protected $mailbox;

    public function login($host, $port, $user, $pass, $folder = 'INBOX', $ssl = false, $options = null)
    {
        $ssl           = ($ssl == false) ? '/novalidate-cert' : '/ssl';
        $options       = $options ?: '/pop3';
        $this->mailbox = new \PhpImap\Mailbox('{'."$host:$port$options$ssl"."}$folder", $user, $pass, storage_path('app/mail_attachments'));

        return $this;
    }

    public function getMessages()
    {
        $mailsIds = $this->mailbox->searchMailbox('ALL');
        if (! $mailsIds) {
            return collect();
        }

        return collect($mailsIds)->map(function ($mail_id) {
            return new IncomingEmail($this->mailbox->getMail($mail_id));
        });
    }

    public function delete($mail_id)
    {
        $this->mailbox->deleteMail($mail_id);
    }

    public function expunge()
    {
        $this->mailbox->expungeDeletedMails();
    }
}
