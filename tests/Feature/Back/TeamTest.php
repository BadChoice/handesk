<?php

namespace Tests\Feature;

use App\Team;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_see_all_teams(){
        $user = factory(User::class)->states("admin")->create();
        $user->teams()->attach( factory(Team::class)->create(["name" => "Awesome team"]) );
        factory(Team::class)->create(["name" => "Impressive team"]);

        $response = $this->actingAs($user)->get('teams');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("Awesome team");
        $response->assertSee("Impressive team");
    }

    /** @test */
    public function non_admin_can_see_only_his_teams(){
        $user = factory(User::class)->create();
        $user->teams()->attach( factory(Team::class)->create(["name" => "Awesome team"]) );
        factory(Team::class)->create(["name" => "Impressive team"]);

        $response = $this->actingAs($user)->get('teams');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("Awesome team");
        $response->assertDontSee("Impressive team");
    }

    /** @test */
    public function an_user_can_see_the_join_page(){
        $user = factory(User::class)->create();
        factory(Team::class)->create(["token" => "A_TOKEN"]);

        $response = $this->actingAs($user)->get('teams/A_TOKEN/join');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('teams/A_TOKEN/join');
    }

    /** @test */
    public function an_user_can_join_team_with_its_public_url(){
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create(["token" => "A_TOKEN"]);

        $response = $this->actingAs($user)->post('teams/A_TOKEN/join');

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue( $team->fresh()->members->contains($user) );
    }

    /** @test */
    public function a_user_can_only_be_joined_once(){
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create(["token" => "A_TOKEN"]);
        $team->members()->attach($user);

        $response = $this->actingAs($user)->post('teams/A_TOKEN/join');

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertCount(1, $team->fresh()->members);
    }

    /** @test */
    public function admin_can_create_teams(){
        $user = factory(User::class)->states('admin')->create();

        $response = $this->actingAs($user)->post('teams', [
            "name" => "Awesome team",
            "email" => "awesome@email.com",
            "slack_webhook_url" => "http://slack.com/webhook"
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        tap(Team::first(), function($team){
            $this->assertEquals("Awesome team", $team->name);
            $this->assertEquals("awesome@email.com", $team->email);
            $this->assertEquals("http://slack.com/webhook", $team->slack_webhook_url);
        });
    }

    /** @test */
    public function non_admin_can_not_create_teams(){
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('teams', [
            "name" => "Awesome team",
            "email" => "awesome@email.com",
            "slack_webhook_url" => "http://slack.com/webhook"
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertNull( Team::first() );
    }

    /** @test */
    public function can_see_team_agents(){
        $team  = factory(Team::class)->create();
        $user1 = factory(User::class)->create(["name" => "User 1"]);
        $user2 = factory(User::class)->create(["name" => "User 2"]);
        $team->members()->attach( $user1 );
        $team->members()->attach( $user2 );

        $response = $this->actingAs($user1)->get("teams/{$team->id}/agents");

        $response->assertStatus( Response::HTTP_OK );
        $response->assertSee("User 1");
        $response->assertSee("User 2");

    }
}