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

class AgentTicketsTest extends TestCase
{
    use RefreshDatabase;

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
}