<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseNewEmails extends Command
{
    protected $signature   = 'handesk:parseNewEmails';
    protected $description = 'Fetches the INBOX emails in the configured account, and creates ideas, tickets or ticket comments for them';

    public function handle()
    {
        \App\Jobs\ParseNewEmails::dispatch();
        $this->info('Done');
    }
}
