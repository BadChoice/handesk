<?php

namespace App\Jobs;

use App\UserSettings;
use App\Mail\DailyTasksMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendDailyTasksEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $users = UserSettings::where('daily_tasks_notification', true)->get()->pluck('user');
        $users->filter()->each(function ($user) {
            $this->sendDailyTasksEmailTo($user);
        });
    }

    private function sendDailyTasksEmailTo($user)
    {
        $tasks = $user->todayTasks;
        if ($tasks->count() == 0) {
            return;
        }
        Mail::to($user)->send(new DailyTasksMail($tasks));
    }
}
