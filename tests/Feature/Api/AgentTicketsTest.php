<?php

namespace Tests\Feature;

use App\Comment;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;
use App\Requester;
use App\Ticket;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class AgentTicketsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_login()
    {
        factory(User::class)->create(['email' => 'admin@handesk.io', 'password' => bcrypt('the-password'), 'token' => 'agent-token', 'admin' => true]);

        $response = $this->post("api/agent/login", ["email" => 'admin@handesk.io', 'password' => 'the-password']);

        $response->assertJsonStructure([
            "data" => [
                "name", "token", "email", "locale"
            ]
        ]);
    }

    /** @test */
    public function can_get_all_open_tickets(){
        factory(User::class)->create(['token' => 'agent-token', 'admin' => true]);
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        factory(Ticket::class,3)->create(["requester_id" => $requester->id]);
        factory(Ticket::class,2)->create(["requester_id" => $requester->id, "status" => Ticket::STATUS_SOLVED]);
        factory(Ticket::class,2)->create();

        $response = $this->get("api/agent/tickets", ["token" => 'agent-token']);

        $response->assertJsonStructure([
            "data" => [
                "*" => [ "title", "status", "created_at", "updated_at", "requester" ]
            ]
        ]);

        $responseJson = json_decode( $response->content() );
        $this->assertCount(5, $responseJson->data);
        $this->assertEquals(1, $responseJson->data[0]->id);
    }

    /** @test */
    public function can_get_ticket_comments()
    {
        factory(User::class)->create(['token' => 'agent-token', 'admin' => true]);
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        $ticket = factory(Ticket::class)->create(["requester_id" => $requester->id]);
        factory(Comment::class, 3)->create(['ticket_id' => $ticket->id]);

        $response = $this->get("api/agent/tickets/{$ticket->id}/comments", ["token" => 'agent-token']);

        $response->assertJsonStructure([
            "data" => [
                "*" => [ "body", "user_id", "author", "created_at"]
            ]
        ]);
    }

    /** @test */
    public function can_comment_a_ticket()
    {
        Notification::fake();
        factory(User::class)->create(['token' => 'agent-token', 'admin' => true]);
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        $ticket = factory(Ticket::class)->create(["requester_id" => $requester->id]);
        factory(Comment::class, 3)->create(['ticket_id' => $ticket->id]);

        $response = $this->post("api/agent/tickets/{$ticket->id}/comments", ["body" => "hello baby", "private" => false], ["token" => 'agent-token']);

        $response->assertJsonStructure([
            "data" => [
                "id" 
            ]
        ]);

        $this->assertCount(4, $ticket->fresh()->comments);
        $this->assertEquals("hello baby", $ticket->fresh()->comments[3]->body);
        $this->assertEquals(0, $ticket->fresh()->comments[3]->private);
    }

    /** @test */
    public function can_comment_a_ticket_as_note()
    {
        Notification::fake();
        factory(User::class)->create(['token' => 'agent-token', 'admin' => true]);
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        $ticket = factory(Ticket::class)->create(["requester_id" => $requester->id]);
        factory(Comment::class, 3)->create(['ticket_id' => $ticket->id]);

        $response = $this->post("api/agent/tickets/{$ticket->id}/comments", ["body" => "hello baby", "private" => true], ["token" => 'agent-token']);

        $response->assertJsonStructure([
            "data" => [
                "id" 
            ]
        ]);

        $this->assertCount(4, $ticket->fresh()->commentsAndNotes);
        $this->assertEquals("hello baby", $ticket->fresh()->commentsAndNotes[3]->body);
        $this->assertEquals(1, $ticket->fresh()->commentsAndNotes[3]->private);
    }
}