<?php

namespace Tests\Unit;

use App\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_subscribe_to_mailchimp(){
        $lead = factory(Lead::class)->create();
        $lead->attachTags(["xef","retail","another tag","even another tag"]);

        $lists = $lead->getSubscribableLists();
        $this->assertCount(2, $lists);
    }

}
