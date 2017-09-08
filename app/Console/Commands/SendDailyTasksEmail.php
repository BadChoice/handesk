<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendDailyTasksEmail extends Command
{
    protected $signature   = 'handesk:sendDailyTasksEmail';
    protected $description = 'Send Daily Tasks Email';

    public function handle()
    {
        dispatch(new \App\Jobs\SendDailyTasksEmail());
        $this->info('Daily tasks email sent');
    }
}
