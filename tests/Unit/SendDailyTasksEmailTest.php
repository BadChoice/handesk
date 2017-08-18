<?php

namespace Tests\Unit;

use App\Jobs\CloseSolvedTickets;
use App\Jobs\SendDailyTasksEmail;
use App\Lead;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SendDailyTasksEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_email_with_daily_tasks_is_sent(){
        $user1 = factory( User::class)->create();
        $user2 = factory( User::class)->create();
        $user3 = factory( User::class)->create();
        $user4 = factory( User::class)->create();

        $user1->settings()->update(["daily_tasks_notification" => true]);
        $user2->settings()->update(["daily_tasks_notification" => true]);
        $user3->settings()->update(["daily_tasks_notification" => false]);

        $lead = factory(Lead::class)->create();
        $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::today(),                         "body" => "Sample task"]);
        $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::today(), "completed" => true,    "body" => "Should not be sent"]);
        $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::yesterday(),                     "body" => "Should not be sent"]);
        $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::tomorrow(),                      "body" => "Should not be sent"]);

        $lead->tasks()->create(["user_id" => $user3->id, "datetime" => Carbon::today(),                         "body" => "Sample task"]);

        dispatch( new SendDailyTasksEmail );

    }

    /** @test */
    public function a_ticket_solved_after_treshold_is_not_closed(){

    }
}
