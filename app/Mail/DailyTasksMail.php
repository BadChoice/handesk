<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyTasksMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tasks;

    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Handesk: Daily tasks')
                    ->view('emails.tasks')
                    ->with(['tasks' => $this->tasks]);
    }
}
