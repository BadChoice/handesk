<?php

namespace Tests\Feature;

use App\Authenticatable\Admin;
use App\Authenticatable\Assistant;
use App\Idea;
use App\Notifications\NewComment;
use App\Notifications\TicketEscalated;
use App\Services\Bitbucket\Bitbucket;
use App\Services\IssueCreator;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Mockery\Mock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_ideas(){
        $user = factory(User::class)->create(["admin" => true]);
        factory(Idea::class)->create(["status" => Idea::STATUS_NEW]);

        $response = $this->actingAs($user)->get('ideas?pending=true');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( Idea::first()->requester->name);
    }

    /** @test */
    public function can_show_an_idea(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(["admin" => true]);
        $idea = factory(Idea::class)->create();

        $response = $this->actingAs($user)->get("ideas/{$idea->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee( $idea->requester->name );
    }

    /** @test */
    public function can_add_a_tag(){
        $user = factory(User::class)->create(["admin" => true]);
        $idea = factory(Idea::class)->create();

        $response = $this->actingAs($user)->post("ideas/{$idea->id}/tags", ["tag" => "Hello world"]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(1, $idea->fresh()->tags);
    }

    /** @test */
    public function can_detach_a_tag(){
        $user   = factory(User::class)->create(["admin" => true]);
        $idea = factory(Idea::class)->create();
        $idea->attachTags(["hello","world"]);
        $this->assertCount(2, $idea->tags);

        $response = $this->actingAs($user)->delete("ideas/{$idea->id}/tags/hello");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(1, $idea->fresh()->tags);
    }

    /** @test */
    public function can_create_an_idea(){
        Notification::fake();
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user)->post('ideas',[
            "requester" => ["name" => "Justin", "email" => "justin@biber.com"],
            "title" => "Hello",
            "body" => "Baby",
            "tags" =>"first tag,second tag",
            "development_effort" => 4,
            "sales_impact" => 5,
            "current_impact" => 3,
        ]);
        
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals(1, Idea::count());
        tap(Idea::first(), function($idea){
            $this->assertEquals("Hello", $idea->title);
            $this->assertEquals("Baby", $idea->body);
            $this->assertEquals("Justin", $idea->requester->name);
            $this->assertEquals("justin@biber.com", $idea->requester->email);
            $this->assertEquals(Idea::STATUS_NEW, $idea->status);
            $this->assertTrue($idea->tags->pluck('name')->contains('second tag'));
        });
    }
}