<?php

namespace Tests\Feature;

use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;
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
    public function can_see_tickets_in_home(){
        $user = factory(User::class)->create();
        $user->tickets()->create(factory(Ticket::class)->make()->toArray());

        $response = $this->actingAs($user)->get('home');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $user->tickets->first()->requester);
    }

    /** @test */
    public function can_see_a_ticket(){
        $user = factory(User::class)->create();
        $user->tickets()->create(factory(Ticket::class)->make()->toArray());
        $ticket = $user->tickets->first();

        $response = $this->actingAs($user)->get("tickets/{$ticket->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $ticket->requester);
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
        $response->assertSee( $ticket->requester);
    }

    /** @test */
    public function user_can_not_see_non_team_ticket(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->get("tickets/{$ticket->id}");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function admin_can_see_non_team_ticket(){
        $user   = factory(User::class)->create(["admin" => true]);
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->get("tickets/{$ticket->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $ticket->requester);
    }
}