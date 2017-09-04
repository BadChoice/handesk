<?php

namespace Tests\Unit\Integrations;

use App\Services\Mailchimp;
use Tests\TestCase;

/** @group integrations */
class MailchimpTest extends TestCase
{
    /** @test */
    public function can_subscribe_and_unsubscribe_to_mailchimp_list(){
        $mailchimp = new Mailchimp();
        $this->assertTrue($mailchimp->unsubscribe("499b95d54d", "jordi.p@revo.works"));

        $this->assertTrue($mailchimp->subscribe("499b95d54d", "jordi.p@revo.works", "Jordi", "Puigdellívol"));
    }
}