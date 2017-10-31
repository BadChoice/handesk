<?php

namespace App\Services;

use PHPUnit\Framework\Assert as PHPUnit;

class MailchimpFake extends Mailchimp
{
    protected $subscribed   = [];
    protected $unsubscribed = [];

    public function __construct()
    {
    }

    public function subscribe($listId, $email, $firstName, $lastName)
    {
        if (! isset($this->subscribed[$email])) {
            $this->subscribed[$email] = [];
        }
        $this->subscribed[$email][] = $listId;
    }

    public function unsubscribe($listId, $email)
    {
        if (! isset($this->unsubscribed[$email])) {
            $this->unsubscribed[$email] = [];
        }
        $this->unsubscribed[$email][] = $listId;
    }

    public function assertSubscribed($email, $listId)
    {
        if (! isset($this->subscribed[$email])) {
            return PHPUnit::fail("{$email} has not been subscribed to {$listId}");
        }
        PHPUnit::assertTrue(
            collect($this->subscribed[$email])->contains($listId), "{$email} has not been subscribed to {$listId}");
    }

    public function assertUnsubscribed($email, $listId)
    {
        if (! isset($this->unsubscribed[$email])) {
            return PHPUnit::fail("{$email} has not been unsubscribed from {$listId}");
        }
        PHPUnit::assertTrue(
            collect($this->unsubscribed[$email])->contains($listId), "{$email} has not been unsubscribed from {$listId}");
    }

    public function assertNotSubscribed($email, $listId)
    {
        if (! isset($this->subscribed[$email])) {
            return PHPUnit::assertTrue(true);
        }
        PHPUnit::assertFalse(
            collect($this->subscribed[$email])->contains($listId), "{$email} has been subscribed from {$listId}");
    }

    public function assertNotUnsubscribed($email, $listId)
    {
        if (! isset($this->unsubscribed[$email])) {
            return PHPUnit::assertTrue(true);
        }
        PHPUnit::assertFalse(
            collect($this->unsubscribed[$email])->contains($listId), "{$email} has been unsubscribed from {$listId}");
    }
}
