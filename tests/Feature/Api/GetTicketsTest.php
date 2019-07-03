<?php

namespace Tests\Feature;

use App\Comment;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;
use App\Requester;
use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_open_tickets(){
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        factory(Ticket::class,3)->create(["requester_id" => $requester->id]);
        factory(Ticket::class,2)->create(["requester_id" => $requester->id, "status" => Ticket::STATUS_SOLVED]);
        factory(Ticket::class,2)->create();

        $response = $this->get("api/tickets?requester=requesterName", ["token" => 'the-api-token']);

        $response->assertJsonStructure([
            "data" => [
                "*" => [ "title", "status", "created_at", "updated_at" ]
            ]
        ]);

        $responseJson = json_decode( $response->content() );
        $this->assertCount(3, $responseJson->data);
        $this->assertEquals(1, $responseJson->data[0]->id);
    }

    /** @test */
    public function can_get_solved_tickets(){
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        factory(Ticket::class,3)->create(["requester_id" => $requester->id]);
        factory(Ticket::class,2)->create(["requester_id" => $requester->id, "status" => Ticket::STATUS_SOLVED]);
        factory(Ticket::class,2)->create();

        $response = $this->get("api/tickets?requester=requesterName&status=solved",["token" => 'the-api-token']);

        $response->assertJsonStructure([
            "data" => [
                "*" => [ "title", "status", "created_at", "updated_at" ]
            ]
        ]);

        $responseJson = json_decode( $response->content() );
        $this->assertCount(2, $responseJson->data);
        $this->assertEquals(4, $responseJson->data[0]->id);
    }

    /** @test */
    public function can_get_closed_tickets(){
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        factory(Ticket::class,3)->create(["requester_id" => $requester->id]);
        factory(Ticket::class,2)->create(["requester_id" => $requester->id, "status" => Ticket::STATUS_CLOSED]);
        factory(Ticket::class,2)->create();

        $response = $this->get("api/tickets?requester=requesterName&status=closed",["token" => 'the-api-token']);

        $response->assertJsonStructure([
            "data" => [
                "*" => [ "title", "status", "created_at", "updated_at" ]
            ]
        ]);

        $responseJson = json_decode( $response->content() );
        $this->assertCount(2, $responseJson->data);
        $this->assertEquals(4, $responseJson->data[0]->id);
    }

    /** @test */
    public function can_get_a_ticket(){
        $ticket = factory(Ticket::class)->create();
        $ticket->comments()->createMany(
          factory(Comment::class,5)->make()->transform(function($comment){return $comment->setAppends([]);})->toArray()
        );

        $response = $this->get("api/tickets/{$ticket->id}",["token" => 'the-api-token']);
        $response->assertJsonStructure([
            "data" => [
                 "title", "body", "status", "created_at", "updated_at", "comments" => [
                    "*" => ["body", "created_at", "user_id"]
                ]
            ]
        ]);
        $this->assertCount(5, $response->json()["data"]["comments"] );
    }

    /** @test */
    public function when_getting_a_ticket_only_public_comments_are_returned(){
        $ticket = factory(Ticket::class)->create();
        $ticket->comments()->createMany(
            factory(Comment::class,2)->make()->transform(function($comment){return $comment->setAppends([]);})->toArray()
        );
        $ticket->comments()->createMany(
            factory(Comment::class,2)->make(["private" => true])->transform(function($comment){return $comment->setAppends([]);})->toArray()
        );

        $response = $this->get("api/tickets/{$ticket->id}",["token" => 'the-api-token']);
        $this->assertCount(2, $response->json()["data"]["comments"] );
    }

}