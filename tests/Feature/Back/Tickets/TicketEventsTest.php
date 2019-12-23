<?php

namespace Tests\Feature\Back;

use App\Services\FakeIssueCreator;
use App\Services\IssueCreator;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketEventsTest extends TestCase
{
    use RefreshDatabase;
    protected $agent;

    public function setUp() : void{
        parent::setup();
        $this->agent = factory(User::class)->create();
        $this->actingAs($this->agent);
        Notification::fake();
    }

    /** @test */
    public function escalating_a_ticket_creates_a_ticket_event(){
            $ticket = factory(Ticket::class)->create();
            $ticket->setLevel(1);

            $this->assertCount(1, $ticket->fresh()->events);
            tap($ticket->fresh()->events->first(), function($event){
               $this->assertEquals($this->agent->id, $event->user->id );
               $this->assertEquals("Escalated", $event->body);
            });
    }

    /** @test */
    public function deescalating_a_ticket_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();
        $ticket->setLevel(0);

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("De-Escalated", $event->body);
        });
    }

    /** @test */
    public function assigning_a_ticket_to_an_agent_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();

        $ticket->assignTo( factory(User::class)->create(["name" => "agent 2"]) );

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("Assigned to agent: agent 2", $event->body);
        });
    }

    /** @test */
    public function assigning_a_ticket_to_a_team_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();

        $ticket->assignToTeam( factory(Team::class)->create(["name" => "awesome team"]) );

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("Assigned to team: awesome team", $event->body);
        });
    }

    /** @test */
    public function creating_ticket_issue_creates_a_ticket_event(){
        $ticket = factory(Ticket::class)->create();

        $ticket->createIssue( new FakeIssueCreator, 'fake/repo' );

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("Issue created #1 at fake/repo", $event->body);
        });
    }

    /** @test */
    public function changing_ticket_status_creates_an_event(){
        $ticket = factory(Ticket::class)->create();

        $ticket->updateStatus(Ticket::STATUS_CLOSED);

        $this->assertCount(1, $ticket->fresh()->events);
        tap($ticket->fresh()->events->first(), function($event){
            $this->assertEquals($this->agent->id, $event->user->id );
            $this->assertEquals("Status updated: closed", $event->body);
        });
    }

}
