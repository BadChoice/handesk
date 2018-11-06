<?php

namespace Tests\Feature;

use App\Idea;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketRatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_rate_a_ticket_when_close()
    {
        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN"]);
        $response = $this->get("requester/tickets/TOKEN/rate?rating=3");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals(3, $ticket->fresh()->rating);
    }

    /** @test */
    public function can_not_rate_a_ticket_without_a_rating()
    {
        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN"]);
        $response = $this->get("requester/tickets/TOKEN/rate");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($ticket->fresh()->rating);
    }

    /** @test */
    public function can_not_rate_a_ticket_when_not_closed()
    {
        $ticket = factory(Ticket::class)->create(["status" => Ticket::STATUS_OPEN, "public_token" => "TOKEN"]);
        $response = $this->get("requester/tickets/TOKEN/rate?rating=2");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($ticket->fresh()->rating);
    }

    public function can_not_rate_a_ticket_when_already_rated(){

    }



    /** @test */
    public function the_rating_email_is_sent_when_order_closed_and_not_rated()
    {
    }

    public function the_rating_email_is_not_sent_when_order_closed_not_rated(){

    }

    /** @test */
    public function the_idea_created_text_uses_the_ticket_language()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create([
            "status" => Ticket::STATUS_OPEN,
            "body" => "Aquest es un comentari en català per veure que el detector d'idioma funciona"
        ]);

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/idea");

        $response->assertStatus( Response::HTTP_FOUND );
        $this->assertContains("Notificació | Banc d'Idees REVO", $ticket->fresh()->commentsAndNotes->first()->body);
    }
}