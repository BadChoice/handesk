<?php

namespace App\Jobs;

use App\Mail\DailyTasksMail;
use App\UserSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
