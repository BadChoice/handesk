<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTicketsFromNewEmails extends Command{
    protected $signature    = 'handesk:createTicketsFromNewEmails';
    protected $description  = 'Fetches the INBOX emails in the configured account, and creates tickets for them';

    public function handle() {
        dispatch( new \App\Jobs\CreateTicketsFromNewEmails() );
        $this->info("Done");
    }
}
