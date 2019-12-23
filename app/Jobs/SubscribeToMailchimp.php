<?php

namespace App\Jobs;

use App\Services\Mailchimp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubscribeToMailchimp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $listId;
    protected $email;
    protected $firstName;
    protected $fullName;

    /**
     * Create a new job instance.
     *
     * @param $listId
     * @param $email
     * @param $firstName
     * @param $fullName
     */
    public function __construct($listId, $email, $firstName, $fullName)
    {
        $this->listId    = $listId;
        $this->email     = $email;
        $this->firstName = $firstName;
        $this->fullName  = $fullName;
    }

    /**
     * Execute the job.
     *
     * @param Mailchimp $mailchimp
     *
     * @return void
     */
    public function handle(Mailchimp $mailchimp)
    {
        $mailchimp->subscribe($this->listId, $this->email, $this->firstName, $this->fullName);
    }
}
