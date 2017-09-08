<?php

namespace Tests\Unit;

use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_tickets_for_admin(){
        $this->markTestSkipped('Not implemented yet');
    }

    /** @test */
    public function can_get_all_tickets_for_non_admin(){
        $this->markTestSkipped('Not implemented yet');
    }

    /** @test */
    public function can_get_assigned_tickets(){
        $this->markTestSkipped('Not implemented yet');
    }

    /** @test */
    public function can_get_unassigned_tickets_for_admin(){
        $this->markTestSkipped('Not implemented yet');
    }

    /** @test */
    public function can_get_unassigned_tickets_for_non_admin(){
        $this->markTestSkipped('Not implemented yet');
    }

    /** @test */
    public function can_get_archived_tickets(){
        $this->markTestSkipped('Not implemented yet');
    }
    
    /** @test */
    public function can_get_recently_updated_tickets(){
        $this->markTestSkipped('Not implemented yet');
    }
}