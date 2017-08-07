<?php

namespace Tests\Feature;

use App\Notifications\NewComment;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TeamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_see_teams(){
        $user = factory(User::class)->states("admin")->create();
        factory(Team::class)->create(["name" => "Awesome team"]);

        $response = $this->actingAs($user)->get('teams');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("Awesome team");
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
}