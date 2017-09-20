<?php

namespace Tests\Feature\Back;

use App\Services\FakeIssueCreator;
use App\Services\IssueCreator;
use App\Team;
use App\Ticket;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketEventsTest extends TestCase
{
    use RefreshDatabase;
    protected $agent;

    public function setUp() {
        parent::setup();
        $this->agent = factory(User::class)->create();
        $this->actingAs($this->agent);
    }

    /** @test */
    public function escalating_a_ticket_creates_a_ticket_event(){
            $ticket = factory(Ticket::class)->create();
            $ticket->setLevel(1);

            $this->assertCount(1, $ticket->fresh()->events);
            tap($ticket->fresh()->events->first(), function($event){
               $this->assertEquals($this->agent->id, $event->user->id );
               $this->assertEquals("Escalated", $event->description);
            });
    }

    /** @test */
    public function deescalating_a_ticket_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();
        $ticket->setLevel(0);

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("De-Escalated", $event->description);
        });
    }

    /** @test */
    public function assigning_a_ticket_to_an_agent_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();

        $ticket->assignTo( factory(User::class)->create(["name" => "agent 2"]) );

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("Assigned to agent: agent 2", $event->description);
        });
    }

    /** @test */
    public function assigning_a_ticket_to_a_team_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();

        $ticket->assignToTeam( factory(Team::class)->create(["name" => "awesome team"]) );

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("Assigned to team: awesome team", $event->description);
        });
    }

    /** @test */
    public function creating_ticket_issue_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();
        $ticket->createIssue( new FakeIssueCreator, null );

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("Issue created", $event->description);
        });

    }

    /** @test */
    public function changing_ticket_status_creates_an_event(){

    }

    /** @test */
    public function reopening_a_ticket_creates_an_event(){

    }
}
