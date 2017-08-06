<?php

namespace Tests\Feature;

use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;
use App\Requester;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GetTicketsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_get_open_tickets(){
        $requester = factory(Requester::class)->create(["name" => "requesterName" ]);
        factory(Ticket::class,3)->create(["requester_id" => $requester->id]);
        factory(Ticket::class,2)->create(["requester_id" => $requester->id, "status" => Ticket::STATUS_SOLVED]);
        factory(Ticket::class,2)->create();

        $response = $this->get("api/tickets?requester=requesterName");

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

        $response = $this->get("api/tickets?requester=requesterName&status=solved");

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

        $response = $this->get("api/tickets?requester=requesterName&status=closed");

        $response->assertJsonStructure([
            "data" => [
                "*" => [ "title", "status", "created_at", "updated_at" ]
            ]
        ]);

        $responseJson = json_decode( $response->content() );
        $this->assertCount(2, $responseJson->data);
        $this->assertEquals(4, $responseJson->data[0]->id);
    }

}