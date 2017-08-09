<?php

namespace Tests\Feature;

use App\Kpi\FirstReplyKpi;
use App\Notifications\NewComment;
use App\Team;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class KpisTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        Notification::fake();
    }

    /** @test */
    public function avg_time_to_first_reply_is_calculated_for_user(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create(["created_at" => Carbon::parse("-5 minutes")]);

        $ticket->addComment(null, "A requester comment");   //A requester comment should not apply
        $this->assertEquals(null, FirstReplyKpi::forUser($user) );

        $ticket->addComment($user, "A test comment");
        $this->assertEquals(5, FirstReplyKpi::forUser($user) );

        $ticket->addComment($user, "A second comment"); //Second comment should not count for the KPI
        $this->assertEquals(5, FirstReplyKpi::forUser($user) );

        $ticket2 = factory(Ticket::class)->create(["created_at" => Carbon::parse("-10 minutes")]);
        $ticket2->addComment($user, "Another comment");

        $this->assertEquals(7.5, FirstReplyKpi::forUser($user) );
    }
//- Avg Time to first reply
//- Avg Time to solve
//- One touch solve ratio
//- Reopened ratio
//- Satisfaction ratio

}