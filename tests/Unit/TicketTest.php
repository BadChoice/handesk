<?php

namespace Tests\Unit;

use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   public function can_attach_tags(){
        $ticket = factory(Ticket::class)->create();
        $ticket->attachTags([
            "tag1", "tag2", "tag1"
        ]);
        $this->assertCount(2, $ticket->tags);
   }

   /** @test */
   public function can_attach_tags_as_string(){
       $ticket = factory(Ticket::class)->create();
       $ticket->attachTags("hello,world,world");
       $this->assertCount(2, $ticket->tags);
   }

   /** @test */
   public function can_get_tags_string(){
       $ticket = factory(Ticket::class)->create();
       $ticket->attachTags(["hello","world"]);
       $this->assertEquals("hello,world", $ticket->tagsString());
   }

   /** @test */
   public function can_detach_a_tag(){
       $ticket = factory(Ticket::class)->create();
       $ticket->attachTags(["hello","world"]);

       $ticket->detachTag("world");

       $this->assertEquals("hello",$ticket->tags[0]->name);
       $this->assertCount(1,$ticket->tags);
   }
   /** @test */
   public function adding_the_first_comment_assigns_the_ticket_to_the_user(){
       Notification::fake();
       $user    = factory(User::class)->create();
       $user2   = factory(User::class)->create();

       $ticket  = factory(Ticket::class)->create();
       $this->assertNull($ticket->fresh()->user);

       $ticket->addComment($user, "A comment");
       $ticket->addComment($user2, "A comment");

       $this->assertEquals($ticket->fresh()->user->id, $user->id);
   }

   /** @test */
   public function adding_a_comment_updates_ticket_timestamp(){
       Notification::fake();
       $ticket  = factory(Ticket::class)->create(["updated_at" => Carbon::parse("-5 days")]);

       $ticket->addComment(null, "A comment");

       $this->assertEquals(Carbon::now()->toDateString(), $ticket->fresh()->updated_at->toDateString());
   }

   /** @test */
   public function adding_an_empty_comment_just_changes_the_status(){
       Notification::fake();
       $user    = factory(User::class)->create();
       $ticket = factory(Ticket::class)->create(["status" => Ticket::STATUS_NEW]);

       $ticket->addComment($user, null, Ticket::STATUS_SOLVED);

       $this->assertCount(0, $ticket->comments);
       $this->assertEquals(Ticket::STATUS_SOLVED, $ticket->status);
   }

   /** @test */
   public function can_merge_tickets(){
       $user    = factory(User::class)->create();

       $ticket1 = factory(Ticket::class)->create(["status" => Ticket::STATUS_NEW]);
       $ticket2 = factory(Ticket::class)->create(["status" => Ticket::STATUS_NEW]);
       $ticket3 = factory(Ticket::class)->create(["status" => Ticket::STATUS_NEW]);

       $ticket1->merge($user,  [$ticket2->id, $ticket3] );

       $this->assertEquals( Ticket::STATUS_NEW,    $ticket1->fresh()->status );
       $this->assertEquals( Ticket::STATUS_MERGED, $ticket2->fresh()->status );
       $this->assertEquals( Ticket::STATUS_MERGED, $ticket3->fresh()->status );
       $this->assertCount(1, $ticket2->commentsAndNotes);
       $this->assertEquals("Merged with #1", $ticket2->commentsAndNotes->first()->body);
       $this->assertCount(1, $ticket3->commentsAndNotes);
       $this->assertEquals("Merged with #1", $ticket3->commentsAndNotes->first()->body);

       $this->assertTrue( $ticket1->mergedTickets->contains($ticket2) );
       $this->assertTrue( $ticket1->mergedTickets->contains($ticket3) );
   }

   /** @test */
   public function merging_to_itself_is_not_merged(){
       $user    = factory(User::class)->create();

       $ticket1 = factory(Ticket::class)->create(["status" => Ticket::STATUS_NEW]);
       $ticket2 = factory(Ticket::class)->create(["status" => Ticket::STATUS_NEW]);

       $ticket1->merge($user,  [$ticket1->id, $ticket2] );

       $this->assertEquals( Ticket::STATUS_NEW,    $ticket1->fresh()->status );
       $this->assertEquals( Ticket::STATUS_MERGED, $ticket2->fresh()->status );
       $this->assertCount(1, $ticket2->commentsAndNotes);
       $this->assertEquals("Merged with #1", $ticket2->commentsAndNotes->first()->body);
       $this->assertCount(0, $ticket1->commentsAndNotes);

       $this->assertTrue( $ticket1->mergedTickets->contains($ticket2) );
   }

   /** @test */
   public function adding_a_comment_when_escalated_it_is_added_as_a_note(){
       $user    = factory(User::class)->create();
       $ticket  = factory(Ticket::class)->create(["level" => 1]);
       $comment = $ticket->addComment($user, "this is a comment");
       $this->assertTrue($comment->private);
   }

    /** @test */
    public function adding_a_requester_comment_when_escalated_it_is_not_added_as_a_note(){
        $ticket  = factory(Ticket::class)->create(["level" => 1]);
        $comment = $ticket->addComment(null, "this is a comment");

        $this->assertFalse($comment->private == true);
    }
}
