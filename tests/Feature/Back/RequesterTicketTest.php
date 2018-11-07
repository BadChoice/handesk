<?php

namespace Tests\Feature;

use App\Notifications\NewComment;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequesterTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_ticket_can_be_accessed_by_the_requester_with_ticket_public_token(){
           factory(Ticket::class)->create(["title" => "A public request", "public_token" => "A_PUBLIC_TOKEN"]);

           $response = $this->get("requester/tickets/A_PUBLIC_TOKEN");

           $response->assertStatus(Response::HTTP_OK);
           $response->assertSee("A public request");
    }

    /** @test */
    public function a_requester_can_comment_a_ticket(){
        Notification::fake();
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create(["public_token" => "A_PUBLIC_TOKEN", "team_id" => $team->id, "user_id" => $user->id]);

        $response = $this->post("requester/tickets/A_PUBLIC_TOKEN/comments", ["body" => "new comment"]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertCount(1, $ticket->fresh()->comments);
        $this->assertEquals(Ticket::STATUS_NEW, $ticket->fresh()->status);

        tap($ticket->fresh()->comments->first(), function($comment) use($ticket){
            Notification::assertNotSentTo($ticket->requester, NewComment::class);
            Notification::assertSentTo(
                [$ticket->user, $ticket->team],
                NewComment::class,
                function ($notification, $channels) use ($ticket, $comment) {
                    return $notification->ticket->id === $ticket->id && $notification->comment->id === $comment->id;
                }
            );
        });
    }

    /** @test */
    public function a_requester_can_comment_and_solve_a_ticket(){
        Notification::fake();
        $ticket = factory(Ticket::class)->create(["public_token" => "A_PUBLIC_TOKEN"]);

        $response = $this->post("requester/tickets/A_PUBLIC_TOKEN/comments", ["body" => "new comment", "solved" => true]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertCount(1, $ticket->fresh()->comments);
        $this->assertEquals(Ticket::STATUS_SOLVED, $ticket->fresh()->status);
    }

    /** @test */
    public function a_requester_can_comment_and_reopen_a_ticket(){
        $ticket = factory(Ticket::class)->create(["public_token" => "A_PUBLIC_TOKEN", "status" => Ticket::STATUS_SOLVED]);

        $response = $this->post("requester/tickets/A_PUBLIC_TOKEN/comments", ["body" => "new comment", "reopen" => true]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertCount(1, $ticket->fresh()->comments);
        $this->assertEquals(Ticket::STATUS_OPEN, $ticket->fresh()->status);
    }
}