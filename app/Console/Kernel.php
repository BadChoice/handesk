<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CloseSolvedTickets::class,
        Commands\ParseNewEmails::class,
        Commands\SendDailyTasksEmail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('handesk:closeSolvedTickets')->dailyAt('23:55');
        $schedule->command('handesk:parseNewEmails')->everyMinute()->withoutOverlapping();
        $schedule->command('handesk:sendDailyTasksEmail')->dailyAt('6:30');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
