<?php

namespace Tests\Feature;

use App\Authenticatable\Assistant;
use App\Notifications\NewComment;
use App\Notifications\TicketEscalated;
use App\Services\Bitbucket\Bitbucket;
use App\Services\IssueCreator;
use App\Team;
use App\ThrustHelpers\Actions\MergeTickets;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Mockery\Mock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_tickets(){
        $user = factory(User::class)->create(["admin" => true]);
        $user->tickets()->create(factory(Ticket::class)->make()->toArray());

        $response = $this->actingAs($user)->get('tickets');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $user->tickets->first()->requester->name);
    }

    /** @test */
    public function can_show_a_ticket_assigned_to_me(){
        $user = factory(User::class)->create();
        $user->tickets()->create(factory(Ticket::class)->make()->toArray());
        $ticket = $user->tickets->first();

        $response = $this->actingAs($user)->get("tickets/{$ticket->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $ticket->requester->name);
    }

    /** @test */
    public function user_can_see_team_ticket(){
        $user   = factory(User::class)->create();
        $team   = factory(Team::class)->create();
        $team->memberships()->create([
            "user_id" => $user->id
        ]);
        $ticket = $team->tickets()->create(
            factory(Ticket::class)->make()->toArray()
        );

        $response = $this->actingAs($user)->get("tickets/{$ticket->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $ticket->requester->name);
    }

    /** @test */
    public function user_can_not_see_non_team_ticket(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->get("tickets/{$ticket->id}");

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function admin_can_see_non_team_ticket(){
        $user   = factory(User::class)->create(["admin" => true]);
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->get("tickets/{$ticket->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $ticket->requester->name);
    }

    /** @test */
    public function can_add_a_comment(){
        Notification::fake();
        $user   = factory(User::class)->create();
        $team   = factory(Team::class)->create();
        $ticket = factory(Ticket::class)->create(["user_id" => $user->id, "team_id" => $team->id]);
        $this->assertCount(0, $ticket->comments);

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/comments",["body" => "This is my comment"]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertCount(1, $ticket->fresh()->comments);
        tap($ticket->fresh()->comments->first(), function($comment) use($user, $ticket){
            $this->assertEquals("This is my comment", $comment->body);
            $this->assertEquals($user->id, $comment->user_id);

            Notification::assertNotSentTo($user, NewComment::class);
            Notification::assertSentTo(
                [$ticket->requester, $ticket->team],
                NewComment::class,
                function ($notification, $channels) use ($ticket, $comment) {
                    return $notification->ticket->id === $ticket->id && $notification->comment->id === $comment->id;
                }
            );
        });
    }

    /** @test */
    public function can_comment_a_ticket_with_a_private_note(){
        Notification::fake();
        $user   = factory(User::class)->create();
        $team   = factory(Team::class)->create();
        $ticket = factory(Ticket::class)->create(["user_id" => $user->id, "team_id" => $team->id]);
        $this->assertCount(0, $ticket->comments);

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/comments",["body" => "This is my comment", "private" => true]);
        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertCount(0, $ticket->fresh()->comments);
        $this->assertCount(1, $ticket->fresh()->commentsAndNotes);

    }

    /** @test */
    public function can_assign_a_ticket_to_a_team(){
        Notification::fake();
        $user   = factory(User::class)->create(["admin" => true]);
        $team   = factory(Team::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/assign",["team_id" => $team->id]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($team->id, $ticket->fresh()->team_id);
    }

    /** @test */
    public function can_assign_a_ticket_to_a_user(){
        Notification::fake();
        $user   = factory(User::class)->create(["admin" => true]);
        $user2  = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/assign",["user_id" => $user2->id]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($user2->id, $ticket->fresh()->user_id);
    }

    /** @test */
    public function can_assign_a_ticket_to_a_user_and_team(){
        Notification::fake();
        $user   = factory(User::class)->create(["admin" => true]);
        $user2  = factory(User::class)->create();
        $team   = factory(Team::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/assign",[
            "user_id" => $user2->id,
            "team_id" => $team->id,
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($user2->id, $ticket->fresh()->user_id);
        $this->assertEquals($team->id, $ticket->fresh()->team_id);
    }

    /** @test */
    public function can_add_a_tag(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/tags", ["tag" => "Hello world"]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(1, $ticket->fresh()->tags);
    }

    /** @test */
    public function can_detach_a_tag(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create();
        $ticket->attachTags(["hello","world"]);
        $this->assertCount(2, $ticket->tags);

        $response = $this->actingAs($user)->delete("tickets/{$ticket->id}/tags/hello");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(1, $ticket->fresh()->tags);
    }

    /** @test */
    public function can_create_a_ticket(){
        Notification::fake();
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();

        $response = $this->actingAs($user)->post('tickets',[
            "requester" => ["name" => "Justin", "email" => "justin@biber.com"],
            "title" => "Hello",
            "body" => "Baby",
            "tags" =>"first tag,second tag",
            "status" => Ticket::STATUS_OPEN,
            "team_id" => $team->id,
        ]);
        
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals(1, Ticket::count());
        tap(Ticket::first(), function($ticket) use($team){
            $this->assertEquals("Hello", $ticket->title);
            $this->assertEquals("Baby", $ticket->body);
            $this->assertEquals("Justin", $ticket->requester->name);
            $this->assertEquals("justin@biber.com", $ticket->requester->email);
            $this->assertEquals(Ticket::STATUS_OPEN, $ticket->status);
            $this->assertEquals($team->id, $ticket->team->id);
            $this->assertTrue($ticket->tags->pluck('name')->contains('second tag'));
        });
    }


    /** @test */
    public function can_merge_tickets(){
        Notification::fake();
        $user    = factory(User::class)->states(['admin'])->create();
        $tickets = factory(Ticket::class, 4)->create();

        $this->actingAs($user);
        request()->merge(['ticket_id' => 1]);
        (new MergeTickets)->handle(Ticket::whereIn('id', [2, 3])->get());

        $this->assertEquals(Ticket::STATUS_MERGED, $tickets[1]->fresh()->status);
        $this->assertEquals(Ticket::STATUS_MERGED, $tickets[2]->fresh()->status);
    }

    /** @test */
    public function can_escalate_a_ticket(){
        Notification::fake();
        $user        = factory(User::class)->create();
        $assistant   = factory(Assistant::class)->create();
        $ticket      = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/escalate");

        $response->assertStatus( Response::HTTP_FOUND );
        $this->assertEquals(1, $ticket->fresh()->level);

        Notification::assertSentTo(
            [$assistant],
            TicketEscalated::class,
            function ($notification, $channels) use ($ticket) {
                return $notification->ticket->id === $ticket->id;
            }
        );
    }

    /** @test */
    public function can_unescalate_ticket(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create(["level" => 1]);

        $response = $this->actingAs($user)->delete("tickets/{$ticket->id}/escalate");

        $response->assertStatus( Response::HTTP_FOUND );
        $this->assertEquals(0, $ticket->fresh()->level);
    }
}