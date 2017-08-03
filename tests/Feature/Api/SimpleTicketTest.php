<?php

namespace Tests\Feature;

use App\Notifications\TicketCreated;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SimpleTicketTest extends TestCase
{
    use DatabaseMigrations;

    private function validParams($overrides = []){
        return array_merge([
            "requester"     => "johndoe",
            "title"         => "App is not working",
            "body"          => "I can't log in into the application",
            "tags"          => ["xef"]
        ], $overrides);
    }

    /** @test */
    public function can_create_a_ticket(){

        Notification::fake();
        $admin      = factory(User::class)->create(["admin" => 1]);
        $nonAdmin   = factory(User::class)->create(["admin" => 0]);

        $response = $this->post('api/tickets',[
            "requester"     => "johndoe",
            "title"         => "App is not working",
            "body"          => "I can't log in into the application",
            "tags"          => ["xef"]
        ]);

        $response->assertStatus( Response::HTTP_CREATED );
        $response->assertJson(["data" => ["id" => 1]]);

        tap( Ticket::first(), function($ticket) use($admin) {
            $this->assertEquals ( $ticket->requester, "johndoe");
            $this->assertEquals ( $ticket->title, "App is not working");
            $this->assertEquals ( $ticket->body, "I can't log in into the application");
            $this->assertTrue   ( $ticket->tags->pluck('name')->contains("xef") );
            $this->assertEquals( Ticket::STATUS_NEW, $ticket->status);

            Notification::assertSentTo(
                [$admin],
                TicketCreated::class,
                function ($notification, $channels) use ($ticket) {
                    return $notification->ticket->id === $ticket->id;
                }
            );
        });


        Notification::assertNotSentTo(
            [$nonAdmin], TicketCreated::class
        );
    }

    /** @test */
    public function requester_is_required(){
        $response = $this->post('api/tickets',$this->validParams([
            "requester" => "",
        ]));
        $response->assertStatus( Response::HTTP_UNPROCESSABLE_ENTITY );
        $response->assertJsonFragment([
            "error" => "The given data failed to pass validation."
        ]);
        $this->assertEquals(0, Ticket::count() );
    }

    /** @test */
    public function title_is_required(){
        $response = $this->post('api/tickets',$this->validParams([
            "title" => "",
        ]));
        $response->assertStatus( Response::HTTP_UNPROCESSABLE_ENTITY );
        $response->assertJsonFragment([
            "error" => "The given data failed to pass validation."
        ]);
        $this->assertEquals(0, Ticket::count() );
    }

    /** @test */
    public function requester_can_comment_the_ticket(){
          $ticket = factory(Ticket::class)->create();
          $ticket->comments()->create(["body" => "first comment"]);

          $response = $this->post("api/tickets/{$ticket->id}/comments", [
              "body" => "this is a comment"
          ]);

        $response->assertStatus ( Response::HTTP_CREATED );
        $response->assertJson   (["data" => ["id" => 2]]);

        $this->assertCount  (2, $ticket->comments);
        $this->assertEquals ($ticket->comments[1]->body, "this is a comment");
    }
}