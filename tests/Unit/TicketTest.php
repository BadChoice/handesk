<?php

namespace Tests\Unit;

use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TicketTest extends TestCase
{
    use DatabaseMigrations;

   /** @test */
   public function can_attach_tags(){
        $ticket = factory(Ticket::class)->create();
        $ticket->attachTags([
            "tag1", "tag2", "tag1"
        ]);
        $this->assertCount(2, $ticket->tags);
   }
}
