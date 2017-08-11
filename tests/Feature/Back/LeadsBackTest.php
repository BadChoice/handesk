<?php

namespace Tests\Feature;

use App\Lead;
use App\Team;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LeadsBackTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_see_all_leads(){
        $user = factory(User::class)->states('admin')->create();
        factory(Lead::class)->create(["email" => "anEmail@email.com"]);

        $response = $this->actingAs($user)->get('leads');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("anEmail@email.com");
        $response->assertSee("New");
    }

    /** @test */
    public function non_admin_can_see_teams_leads(){
        $user   = factory(User::class)->create();
        $team   = factory(Team::class)->create();
        $team->memberships()->create([
            "user_id" => $user->id
        ]);

        factory(Lead::class)->create(["team_id" => $team->id, "email" => "anEmail@email.com"]);
        factory(Lead::class)->create(["email" => "another@email.com"]);

        $response = $this->actingAs($user)->get('leads');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("anEmail@email.com");
        $response->assertDontSee("another@email.com");
        $response->assertSee("New");
    }
}
