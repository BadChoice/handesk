<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseNewEmails extends Command
{
    protected $signature   = 'handesk:parseNewEmails';
    protected $description = 'Fetches the INBOX emails in the configured account, and creates ideas, tickets or ticket comments for them';

    public function handle()
    {
        $job = new \App\Jobs\ParseNewEmails;
        dispatch($job);
        $this->info('Done: '.$job->messagesParsed);
    }
}
