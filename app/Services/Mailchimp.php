<?php

namespace App\Services;

use Config;
use DrewM\MailChimp\MailChimp as MailServer;

class Mailchimp
{
    protected $mailServer;

    public function __construct()
    {
        $this->mailServer = new MailServer(config('services.mailchimp.api_key'));
    }

    public function subscribe($listId, $email, $firstName, $lastName)
    {
        $this->mailServer->post("lists/$listId/members", [
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME' => $firstName,
                'LNAME' => $lastName,
            ],
        ]);

        return $this->mailServer->success();
    }

    public function unsubscribe($listId, $email)
    {
        $subscriberHash = $this->mailServer->subscriberHash($email);
        $this->mailServer->delete("lists/$listId/members/$subscriberHash");

        return $this->mailServer->success();
    }
}
