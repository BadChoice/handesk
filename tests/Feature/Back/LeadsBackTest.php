<?php

namespace Tests\Feature;

use App\Lead;
use App\Team;
use App\User;
use Carbon\Carbon;
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

    /** @test */
    public function can_see_a_leads_detail(){
        $user   = factory(User::class)->create();
        $lead   = factory(Lead::class)->create(["email" => "another@email.com"]);

        $response = $this->actingAs($user)->get("leads/{$lead->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function can_update_lead_status() {
        $user   = factory(User::class)->create();
        $lead   = factory(Lead::class)->create(["email" => "another@email.com", "status" => Lead::STATUS_NEW, "updated_at" => Carbon::parse("-2 days") ]);

        $response = $this->actingAs($user)->post("leads/{$lead->id}/status", ["status" => Lead::STATUS_FIRST_CONTACT, "body" => "I've visited them"]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(1, $lead->fresh()->statusUpdates );
        $this->assertEquals( $lead->fresh()->status,     Lead::STATUS_FIRST_CONTACT);
        $this->assertEquals( $lead->fresh()->updated_at, Carbon::now() );
        tap( $lead->fresh()->statusUpdates->first() , function($statusUpdate) use($user){
            $this->assertEquals(  Lead::STATUS_FIRST_CONTACT, $statusUpdate->status);
            $this->assertEquals( "I've visited them", $statusUpdate->body);
            $this->assertEquals( $user->id, $statusUpdate->user->id);
        });
    }
}
