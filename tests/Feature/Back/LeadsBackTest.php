<?php

namespace Tests\Feature;

use App\Lead;
use App\Notifications\LeadAssigned;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadsBackTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function admin_can_see_all_leads(){
        $this->withoutExceptionHandling();
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
        $lead   = factory(Lead::class)->create(["email" => "another@email.com", "user_id" => $user->id]);

        $response = $this->actingAs($user)->get("leads/{$lead->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function can_not_see_a_lead_that_is_not_mine(){
        $user   = factory(User::class)->create();
        $lead   = factory(Lead::class)->create(["email" => "another@email.com"]);

        $response = $this->actingAs($user)->get("leads/{$lead->id}");

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function can_update_lead_status() {
        $user   = factory(User::class)->states('admin')->create();
        $lead   = factory(Lead::class)->create(["email" => "another@email.com", "status" => Lead::STATUS_NEW, "updated_at" => Carbon::parse("-2 days") ]);

        $response = $this->actingAs($user)->post("leads/{$lead->id}/status", ["new_status" => Lead::STATUS_FIRST_CONTACT, "body" => "I've visited them"]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertCount(1, $lead->fresh()->statusUpdates );
        $this->assertEquals( $lead->fresh()->status,     Lead::STATUS_FIRST_CONTACT);
        $this->assertEquals( $lead->fresh()->updated_at->toDateString(), Carbon::now()->toDateString() );
        tap( $lead->fresh()->statusUpdates->first() , function($statusUpdate) use($user){
            $this->assertEquals(  Lead::STATUS_FIRST_CONTACT, $statusUpdate->new_status);
            $this->assertEquals( "I've visited them", $statusUpdate->body);
            $this->assertEquals( $user->id, $statusUpdate->user->id);
        });
    }

    /** @test */
    public function can_update_a_lead(){
        $user   = factory(User::class)->states('admin')->create();
        $lead   = factory(Lead::class)->create(["email" => "another@email.com", "company" => "A company" ]);

        $response = $this->actingAs($user)->put("leads/{$lead->id}", ["email" => "new@email.com", "company" => "Another company"]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals("Another company",  $lead->fresh()->company);
        $this->assertEquals("new@email.com",    $lead->fresh()->email);
    }

    /** @test */
    public function can_assign_a_user_and_team(){
        Notification::fake();
        $user   = factory(User::class)->states('admin')->create();
        $team   = factory(Team::class)->create();
        $lead   = factory(Lead::class)->create(["email" => "another@email.com", "company" => "A company" ]);

        $response = $this->actingAs($user)->post("leads/{$lead->id}/assign", ["user_id" => $user->id, "team_id" => $team->id]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($user->id,  $lead->fresh()->user->id);
        $this->assertEquals($team->id,  $lead->fresh()->team->id);

        Notification::assertSentTo([$user, $team], LeadAssigned::class, function($notification,$channels) use($lead){
                return $lead->id == $notification->lead->id;
            }
        );
    }

    /** @test */
    public function can_create_a_lead(){
        Notification::fake();
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();

        $response = $this->actingAs($user)->post('leads',[
            "email" => "justin@biber.com",
            "name"  => "Jason mandela",
            "company"  => "Wayne",
            "team_id" => $team->id,
            "tags" => "first tag,second tag"
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals(1, Lead::count());
        tap(Lead::first(), function($lead) use($team){
            $this->assertEquals("Wayne", $lead->company);
            $this->assertEquals("Jason mandela", $lead->name);
            $this->assertEquals("justin@biber.com", $lead->email);
            $this->assertEquals(Lead::STATUS_NEW, $lead->status);
            $this->assertEquals($team->id, $lead->team->id);
            $this->assertTrue($lead->tags->pluck('name')->contains('second tag'));
        });
    }

    /** @test */
    public function can_not_create_a_duplicated_lead_email(){
        $user = factory(User::class)->create();
        factory(Lead::class)->create(["email" => "an_email@email.com", "phone" => "666777888"]);

        $response = $this->actingAs($user)->post('leads',[
            "email"   => "an_email@email.com",
            "name"    => "Jason mandela",
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(["email"]);
        $this->assertEquals(1, Lead::count() );
    }

    /** @test */
    public function can_not_create_a_duplicated_lead_phone(){
        $user = factory(User::class)->create();
        factory(Lead::class)->create(["email" => "an_email@email.com", "phone" => "666777888"]);

        $response = $this->actingAs($user)->post('leads',[
            "email"   => "another_email@email.com",
            "phone"   => "666777888",
            "name"    => "Jason mandela",
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(["phone"]);
        $this->assertEquals(1, Lead::count() );
    }
}
