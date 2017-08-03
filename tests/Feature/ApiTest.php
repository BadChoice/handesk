<?php

namespace Tests\Feature;

use App\Ticket;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApiTest extends TestCase
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

        $response = $this->post('api/tickets',[
            "requester"     => "johndoe",
            "title"         => "App is not working",
            "body"          => "I can't log in into the application",
            "tags"          => ["xef"]
        ]);

        $response->assertStatus( Response::HTTP_CREATED );
        $response->assertJson(["id" => 1]);

        tap( Ticket::first(), function($ticket){
            $this->assertEquals ( $ticket->requester, "johndoe");
            $this->assertEquals ( $ticket->title, "App is not working");
            $this->assertEquals ( $ticket->body, "I can't log in into the application");
            $this->assertTrue   ( $ticket->tags->pluck('name')->contains("xef") );
        });
    }

    /** @test */
    public function requester_is_required(){
        $response = $this->post('api/tickets',$this->validParams([
            "requester" => "",
        ]));
        $response->assertStatus( Response::HTTP_UNPROCESSABLE_ENTITY );
        $response->assertJsonFragment([
            "error" => "requester is required"
        ]);
        $this->assertEquals(0, Ticket::count() );
    }
}
