<?php

namespace App\Jobs;

use App\Ticket;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CloseSolvedTickets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $thresholdDays;

    public function __construct($thresholdDays = 4)
    {
        $this->thresholdDays = $thresholdDays;
    }

    public function handle()
    {
        Ticket::whereStatus(Ticket::STATUS_SOLVED)
                ->where('created_at', '<', Carbon::parse("-{$this->thresholdDays} days"))
                ->update(['status' => Ticket::STATUS_CLOSED]);
    }
}
