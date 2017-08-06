<?php

namespace Tests\Feature;

use App\Notifications\NewComment;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BackTest extends TestCase
{
    use DatabaseMigrations;

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

        // assert notification sent to requester, team, but not sent to user
        //TODO: assert notifications
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
}