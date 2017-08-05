<?php

namespace Tests\Unit;

use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TicketsRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_get_all_tickets_for_admin(){

    }

    /** @test */
    public function can_get_all_tickets_for_non_admin(){

    }

    /** @test */
    public function can_get_assigned_tickets(){

    }

    /** @test */
    public function can_get_unassigned_tickets_for_admin(){

    }

    /** @test */
    public function can_get_unassigned_tickets_for_non_admin(){

    }

    /** @test */
    public function can_get_archived_tickets(){

    }
}