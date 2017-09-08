<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTicketsFromNewEmails extends Command
{
    protected $signature    = 'handesk:createTicketsFromNewEmails';
    protected $description  = 'Fetches the INBOX emails in the configured account, and creates tickets for them';

    public function handle()
    {
        $job = new \App\Jobs\CreateTicketsFromNewEmails();
        dispatch($job);
        $this->info("New Tickets: {$job->newTickets}");
        $this->info("New Comments: {$job->newComments}");
    }
}
