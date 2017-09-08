<?php

namespace Tests\Unit;

use App\Jobs\CloseSolvedTickets;
use App\Jobs\SendDailyTasksEmail;
use App\Lead;
use App\Mail\DailyTasksMail;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendDailyTasksEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_email_with_daily_tasks_is_sent(){

        Mail::fake();

        $user1 = factory( User::class )->create();
        $user2 = factory( User::class )->create();
        $user3 = factory( User::class )->create();
        $user4 = factory( User::class )->create();

        $user1->settings()->updateOrCreate([], ["daily_tasks_notification" => true]);
        $user2->settings()->updateOrCreate([], ["daily_tasks_notification" => true]);
        $user3->settings()->updateOrCreate([], ["daily_tasks_notification" => false]);

        $lead = factory(Lead::class)->create();
        $task1 = $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::today(),                         "body" => "Sample task"]);
        $task2 = $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::today(), "completed" => true,    "body" => "Should not be sent"]);
        $task3 = $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::yesterday(),                     "body" => "Should be sent"]);
        $task4 = $lead->tasks()->create(["user_id" => $user1->id, "datetime" => Carbon::tomorrow(),                      "body" => "Should not be sent"]);
        $task5 = $lead->tasks()->create(["user_id" => $user3->id, "datetime" => Carbon::today(),                         "body" => "Sample task"]);

        dispatch( new SendDailyTasksEmail );

        Mail::assertSent(DailyTasksMail::class, function ($mail) use ($lead, $user1, $task1, $task2, $task3, $task4, $task5) {
            return $mail->hasTo($user1->email) &&
                $mail->tasks->pluck('id')->contains($task1->id) &&
                $mail->tasks->pluck('id')->contains($task3->id) &&
                ! $mail->tasks->pluck('id')->contains($task2->id) &&
                ! $mail->tasks->pluck('id')->contains($task4->id);
        });

        Mail::assertNotSent(DailyTasksMail::class, function($mail) use($user2){
            return $mail->hasTo($user2->email); //Notification enable, but no pending tasks
        });

        Mail::assertNotSent(DailyTasksMail::class, function($mail) use($user3){
            return $mail->hasTo($user3->email); //No notifications enabled
        });

        Mail::assertNotSent(DailyTasksMail::class, function($mail) use($user4){
            return $mail->hasTo($user4->email); //No settings created yet
        });
    }
}
