<?php

namespace Tests\Unit;

use App\Lead;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LeadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_subscribe_to_mailchimp(){
        $lead = factory(Lead::class)->create();
        $lead->attachTags(["xef","retail","another tag","even another tag"]);

        $lists = $lead->getSubscribableLists();
        $this->assertCount(2, $lists);
    }

}
