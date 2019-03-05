<?php

namespace Tests\Feature;

use App\Idea;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketIdeaTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
      public function can_create_idea_from_ticket()
      {
        Notification::fake();
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create([
            "status" => Ticket::STATUS_OPEN,
            "body" => "An english body to make sure it is parsed as english"
        ]);

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/idea");

        $response->assertStatus( Response::HTTP_FOUND );
        $this->assertEquals(Ticket::STATUS_SOLVED, $ticket->fresh()->status);
        $this->assertEquals(1, $ticket->fresh()->commentsAndNotes->count() );
        $this->assertContains("Notification | Ideas bucket", $ticket->fresh()->commentsAndNotes->first()->body);
        $this->assertContains("Idea created #1", $ticket->fresh()->events->first()->body);
        $this->assertEquals(1, Idea::count());
        $this->assertEquals(Idea::first()->title, $ticket->title);
        $this->assertEquals(Idea::first()->body, $ticket->body);
    }

    /** @test */
    public function can_not_create_idea_twice_from_ticket()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/idea");
        $response->assertStatus( Response::HTTP_FOUND );

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/idea");
        $response->assertStatus( Response::HTTP_INTERNAL_SERVER_ERROR );
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