<?php

namespace Tests\Unit;

use App\Jobs\CloseSolvedTickets;
use App\Ticket;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CloseSolvedTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_ticket_solved_before_threshold_is_closed(){
        $ticket1 = factory(Ticket::class)->create([
            "created_at" => Carbon::parse("-1 days"),
            "status"     => Ticket::STATUS_SOLVED
        ]);
        $ticket2 = factory(Ticket::class)->create([
            "created_at" => Carbon::parse("-5 days"),
            "status"     => Ticket::STATUS_SOLVED
        ]);
        $ticket3 = factory(Ticket::class)->create([
            "created_at" => Carbon::parse("-5 days"),
            "status"     => Ticket::STATUS_NEW
        ]);

        dispatch( new CloseSolvedTickets(4) );

        $this->assertEquals(Ticket::STATUS_SOLVED,  $ticket1->fresh()->status);
        $this->assertEquals(Ticket::STATUS_CLOSED,  $ticket2->fresh()->status);
        $this->assertEquals(Ticket::STATUS_NEW,     $ticket3->fresh()->status);
    }
}
