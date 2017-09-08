<?php

namespace Tests\Unit;

use App\Team;
use App\Ticket;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_its_team_tickets(){
        $user       = factory(User::class)  ->create();
        $teams      = factory(Team::class,3)->create();
        $ticket1    = $teams[0]->tickets()->create( factory(Ticket::class)->make()->toArray() );
        $ticket2    = $teams[1]->tickets()->create( factory(Ticket::class)->make()->toArray() );
        $ticket3    = $teams[2]->tickets()->create( factory(Ticket::class)->make()->toArray() );

        $teams[0]->members()->attach($user);
        $teams[1]->members()->attach($user);

        $this->assertCount(2, $user->teamsTickets);
        $this->assertTrue(  $user->teamsTickets->contains($ticket1) );
        $this->assertTrue(  $user->teamsTickets->contains($ticket2) );
        $this->assertFalse( $user->teamsTickets->contains($ticket3) );
    }

}
