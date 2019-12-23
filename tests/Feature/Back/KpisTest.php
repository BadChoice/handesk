<?php

namespace Tests\Feature;

use App\Kpi\FirstReplyKpi;
use App\Kpi\Kpi;
use App\Kpi\OneTouchResolutionKpi;
use App\Kpi\ReopenedKpi;
use App\Kpi\SolveKpi;
use App\Team;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KpisTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void {
        parent::setUp();
        Notification::fake();
    }

    /** @test */
    public function avg_time_to_first_reply_is_calculated_for_user(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create(["created_at" => Carbon::parse("-5 minutes")]);

        $firstReplyKpi = new FirstReplyKpi;

        $ticket->addComment(null, "A requester comment");   //A requester comment should not apply
        $this->assertEquals(null, $firstReplyKpi->forUser($user) );

        $ticket->addComment($user, "", Ticket::STATUS_OPEN);   //A status only
        $this->assertEquals(null, $firstReplyKpi->forUser($user) );

        $ticket->addComment($user, "A test comment");
        $this->assertEquals(5, $firstReplyKpi->forUser($user) );

        $ticket->addComment($user, "A second comment"); //Second comment should not count for the KPI
        $this->assertEquals(5, $firstReplyKpi->forUser($user) );

        $ticket = factory(Ticket::class)->create(["created_at" => Carbon::parse("-10 minutes")]);
        $ticket->addComment($user, "Another comment");

        $this->assertEquals(7.5, $firstReplyKpi->forUser($user) );

        $user2   = factory(User::class)->create();
        $ticket2 = factory(Ticket::class)->create(["created_at" => Carbon::parse("-15 minutes")]);
        $ticket2->addComment($user2, "Another comment");

        $this->assertEquals(15, $firstReplyKpi->forUser($user2) );
    }

    /** @test */
    public function average_first_reply_time_is_calculated_for_team(){
        $user   = factory(User::class)->create();
        $team   = factory(Team::class)->create();
        $ticket = $team->tickets()->create(
            factory(Ticket::class)->make(["created_at" => Carbon::parse("-5 minutes")])->toArray()
        );

        $ticket->addComment($user, "A second comment"); //Second comment should not count for the KPI
        $this->assertEquals(5, (new FirstReplyKpi)->forTeam($team) );
    }

    /** @test */
    public function can_get_the_first_reply_average_for_all(){
        $user1  = factory(User::class)->create();
        $user2  = factory(User::class)->create();
        FirstReplyKpi::obtain( Carbon::today(),         $user1->id, Kpi::TYPE_USER )->addValue( 5 );
        FirstReplyKpi::obtain( Carbon::today(),         $user1->id, Kpi::TYPE_USER )->addValue( 10 );
        FirstReplyKpi::obtain( Carbon::yesterday(),     $user1->id, Kpi::TYPE_USER )->addValue( 20 );

        FirstReplyKpi::obtain( Carbon::today(),       $user2->id, Kpi::TYPE_USER )->addValue( 20 );
        FirstReplyKpi::obtain( Carbon::today(),       $user2->id, Kpi::TYPE_USER )->addValue( 30 );
        FirstReplyKpi::obtain( Carbon::yesterday(),   $user2->id, Kpi::TYPE_USER )->addValue( 40 );

        $this->assertEquals( (5 + 10 + 20 + 20 + 30 + 40) / 6, (new FirstReplyKpi)->forType(Kpi::TYPE_USER));
    }

    /** @test */
    public function average_solve_time_is_calculated_for_user(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create(["created_at" => Carbon::parse("-5 minutes")]);
        $solveKpi = new SolveKpi;

        $ticket->addComment(null, "A requester comment");   //A requester comment should not apply
        $this->assertEquals(null, $solveKpi->forUser($user) );

        $ticket->addComment(null, "A requester comment", Ticket::STATUS_OPEN);   //Not solving the ticket should not count
        $this->assertEquals(null, $solveKpi->forUser($user) );

        $ticket->addComment($user, "A requester comment", Ticket::STATUS_SOLVED);
        $this->assertEquals(5, $solveKpi->forUser($user) );
    }

    /** @test */
    public function solve_time_is_calculated_when_only_updating_the_status(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create(["created_at" => Carbon::parse("-5 minutes")]);

        $ticket->addComment($user, null, Ticket::STATUS_SOLVED);

        $this->assertEquals(5, (new SolveKpi)->forUser($user) );
    }

    /** @test */
    public function average_solve_time_is_calculated_for_team(){
        $user   = factory(User::class)->create();
        $team   = factory(Team::class)->create();
        $ticket = $team->tickets()->create(
            factory(Ticket::class)->make(["created_at" => Carbon::parse("-5 minutes")])->toArray()
        );

        $ticket->addComment($user, "A second comment", Ticket::STATUS_SOLVED); //Second comment should not count for the KPI
        $this->assertEquals(5, (new SolveKpi)->forTeam($team) );
    }

    /** @test */
    public function one_touch_ratio_is_calculated_for_user(){
        $user       = factory(User::class)->create();
        $ticket1    = factory(Ticket::class)->create();
        $ticket2    = factory(Ticket::class)->create();
        $ticket3    = factory(Ticket::class)->create();

        $ticket1->addComment($user, "A requester comment", Ticket::STATUS_OPEN);
        $ticket1->addComment($user, "A requester comment", Ticket::STATUS_SOLVED);   //No one touch resolution

        $ticket2->addComment($user, "A requester comment", Ticket::STATUS_SOLVED);   //One touch resolution

        $ticket3->addComment(null, "A requester comment");                           //A requester comment should not apply
        $ticket3->addComment($user, "A requester comment", Ticket::STATUS_SOLVED);   //One touch resolution

        $this->assertEquals(2/3, (new OneTouchResolutionKpi)->forUser($user) );
    }

    /** @test */
    public function reopened_ratio_is_calculated_for_user(){
        $user       = factory(User::class)->create();
        $ticket1    = $user->tickets()->create( factory(Ticket::class)->make()->toArray() );
        $ticket2    = $user->tickets()->create( factory(Ticket::class)->make()->toArray() );
        $ticket3    = $user->tickets()->create( factory(Ticket::class)->make()->toArray() );

        $ticket1->addComment($user, "A requester comment",  Ticket::STATUS_SOLVED);
        $ticket1->addComment(null, "A requester comment",   Ticket::STATUS_OPEN);

        $ticket1->addComment($user, "A requester comment",  Ticket::STATUS_OPEN);
        $ticket2->addComment($user, "A requester comment",  Ticket::STATUS_SOLVED);

        $this->assertEquals(1/2, (new ReopenedKpi)->forUser($user) );
    }
//- Reopened ratio
//- Satisfaction ratio

}