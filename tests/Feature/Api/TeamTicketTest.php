<?php

namespace Tests\Feature;

use App\Lead;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;
use App\Requester;
use App\Settings;
use App\Team;
use App\Ticket;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTicketTest extends TestCase
{
    use RefreshDatabase;

    private function validParams($overrides = []){
        return array_merge([
            "requester"     => [
                "name" => "johndoe",
                "email" => "john@doe.com"
            ],
            "title"         => "App is not working",
            "body"          => "I can't log in into the application",
            "tags"          => ["xef"]
        ], $overrides);
    }

    /** @test */
    public function can_create_a_team()
    {
        $response = $this->post('api/teams',[
            "name" => "team name",
            "email" => "email@email.com",
            "slack_webhook_url" => null
        ],["token" => 'the-api-token']);

        $response->assertStatus( Response::HTTP_CREATED );
        $response->assertJson(["data" => ["id" => 1]]);

        $this->assertEquals(1, Team::count());
        tap (Team::first(), function($team) {
             $this->assertEquals("team name", $team->name);
             $this->assertEquals("email@email.com", $team->email);
             $this->assertNull($team->slack_webhook_url);
        });
    }

    /** @test */
    public function can_create_a_ticket(){
        Notification::fake();
        $team = factory(Team::class)->create();

        $response = $this->post('api/tickets',[
            "requester"     => [
                "name" => "johndoe",
                "email" => "john@doe.com"
            ],
            "title"         => "App is not working",
            "body"          => "I can't log in into the application",
            "tags"          => ["xef"],
            "team_id"       => $team->id
        ],["token" => 'the-api-token']);

        $response->assertStatus( Response::HTTP_CREATED );
        $response->assertJson(["data" => ["id" => 1]]);

        tap( Ticket::first(), function($ticket) use($team) {
            tap( Requester::first(), function($requester) use ($ticket){
                $this->assertEquals($requester->name, "johndoe");
                $this->assertEquals($requester->email, "john@doe.com");
                $this->assertEquals( $ticket->requester_id, $requester->id);
            });
            $this->assertEquals ( $ticket->title, "App is not working");
            $this->assertEquals ( $ticket->body, "I can't log in into the application");
            $this->assertTrue   ( $ticket->tags->pluck('name')->contains("xef") );
            $this->assertEquals( Ticket::STATUS_NEW, $ticket->status);
            $this->assertTrue( $team->tickets->contains($ticket) );

            Notification::assertSentTo(
                [$team],
                TicketAssigned::class,
                function ($notification, $channels) use ($ticket) {
                    return $notification->ticket->id === $ticket->id;
                }
            );
        });
    }

    /** @test */
    public function a_ticket_created_without_team_notifies_the_default_setting(){
        Notification::fake();

        $setting = factory(Settings::class)->create(["slack_webhook_url" => "http://fake-slack-webhook-url.com"]);

        $response = $this->post('api/tickets',[
            "requester"     => [
                "name" => "johndoe",
                "email" => "john@doe.com"
            ],
            "title"         => "App is not working",
            "body"          => "I can't log in into the application",
            "tags"          => ["xef"],
            "team_id"       => null
        ],["token" => 'the-api-token']);

        $response->assertStatus( Response::HTTP_CREATED );
        $response->assertJson(["data" => ["id" => 1]]);

        tap( Ticket::first(), function($ticket) use($setting) {
            Notification::assertSentTo(
                [$setting],
                TicketCreated::class,
                function ($notification, $channels) use ($ticket) {
                    return $notification->ticket->id === $ticket->id;
                }
            );
        });
    }

     /** @test */
      public function can_get_open_team_tickets()
      {
          $team = factory(Team::class)->create();
          factory(Ticket::class, 1)->create(["team_id" => $team->id, "status" => Ticket::STATUS_SOLVED]);
          factory(Ticket::class, 2)->create(["team_id" => $team->id, "status" => Ticket::STATUS_CLOSED]);
          factory(Ticket::class, 3)->create(["team_id" => $team->id, "status" => Ticket::STATUS_OPEN]);
          factory(Ticket::class, 4)->create(["team_id" => $team->id, "status" => Ticket::STATUS_NEW]);

          $response = $this->get("api/teams/{$team->id}/tickets",["token" => 'the-api-token']);

          $response->assertStatus(Response::HTTP_OK);
          $response->assertJsonStructure([
              "data" => [
                  "*" => [ "title", "status", "created_at", "updated_at" ]
              ]
          ]);

          $responseJson = json_decode( $response->content() );
          $this->assertCount(7, $responseJson->data);
          $this->assertEquals(4, $responseJson->data[0]->id);
      }

    /** @test */
    public function can_get_solved_team_tickets()
    {
        $team = factory(Team::class)->create();
        factory(Ticket::class, 1)->create(["team_id" => $team->id, "status" => Ticket::STATUS_SOLVED]);
        factory(Ticket::class, 2)->create(["team_id" => $team->id, "status" => Ticket::STATUS_CLOSED]);
        factory(Ticket::class, 3)->create(["team_id" => $team->id, "status" => Ticket::STATUS_OPEN]);
        factory(Ticket::class, 4)->create(["team_id" => $team->id, "status" => Ticket::STATUS_NEW]);

        $response = $this->get("api/teams/{$team->id}/tickets?status=solved",["token" => 'the-api-token']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "data" => [
                "*" => [ "title", "status", "created_at", "updated_at" ]
            ]
        ]);

        $responseJson = json_decode( $response->content() );
        $this->assertCount(1, $responseJson->data);
        $this->assertEquals(1, $responseJson->data[0]->id);
    }

    /** @test */
    public function can_get_open_tickets_count()
    {
        $team = factory(Team::class)->create();
        factory(Ticket::class, 1)->create(["team_id" => $team->id, "status" => Ticket::STATUS_SOLVED]);
        factory(Ticket::class, 2)->create(["team_id" => $team->id, "status" => Ticket::STATUS_CLOSED]);
        factory(Ticket::class, 3)->create(["team_id" => $team->id, "status" => Ticket::STATUS_OPEN]);
        factory(Ticket::class, 4)->create(["team_id" => $team->id, "status" => Ticket::STATUS_NEW]);

        $response = $this->get("api/teams/{$team->id}/tickets?count=true",["token" => 'the-api-token']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "data" => [
                "count" => 7
            ]
        ]);
    }

    /** @test */
    public function can_get_open_leads_count()
    {
        $team = factory(Team::class)->create();
        factory(Lead::class, 1)->create(["team_id" => $team->id, "status" => Lead::STATUS_NEW]);
        factory(Lead::class, 2)->create(["team_id" => $team->id, "status" => Lead::STATUS_FIRST_CONTACT]);
        factory(Lead::class, 3)->create(["team_id" => $team->id, "status" => Lead::STATUS_VISITED]);
        factory(Lead::class, 4)->create(["team_id" => $team->id, "status" => Lead::STATUS_COMPLETED]);
        factory(Lead::class, 4)->create(["team_id" => $team->id, "status" => Lead::STATUS_FAILED]);

        $response = $this->get("api/teams/{$team->id}/leads?count=true",["token" => 'the-api-token']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "data" => [
                "count" => 6
            ]
        ]);
    }
}