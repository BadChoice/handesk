<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CloseSolvedTickets extends Command
{
    protected $signature   = 'handesk:closeSolvedTickets';
    protected $description = 'Closed the solved tickets 4 days ago';

    public function handle()
    {
        dispatch(new \App\Jobs\CloseSolvedTickets());
        $this->info('Tickets closed');
    }
}
