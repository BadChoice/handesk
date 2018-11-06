<?php

namespace Tests\Feature;

use App\Authenticatable\Admin;
use App\Kpi\Kpi;
use App\Notifications\RateTicket;
use App\Notifications\TicketRatedNotification;
use App\Requester;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class TicketRatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_rate_a_ticket_when_close()
    {
        Notification::fake();
        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN"]);
        $response = $this->get("requester/tickets/TOKEN/rate?rating=3");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals(3, $ticket->fresh()->rating);
    }

    /** @test */
    public function can_not_rate_a_ticket_without_a_rating()
    {
        Notification::fake();
        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN"]);
        $response = $this->get("requester/tickets/TOKEN/rate");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($ticket->fresh()->rating);
    }

    /** @test */
    public function can_not_rate_a_ticket_when_not_closed()
    {
        Notification::fake();
        $ticket = factory(Ticket::class)->create(["status" => Ticket::STATUS_OPEN, "public_token" => "TOKEN"]);
        $response = $this->get("requester/tickets/TOKEN/rate?rating=2");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($ticket->fresh()->rating);
    }

    /** @test */
    public function notification_is_sent_when_a_ticket_is_rated(){
        Notification::fake();
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN", 'user_id' => $user->id]);
        $response = $this->get("requester/tickets/TOKEN/rate?rating=3");

        $response->assertStatus(Response::HTTP_OK);

        Notification::assertSentTo([$admin, $user], TicketRatedNotification::class,
            function ($notification, $channels) use ($ticket) {
                return $notification->ticket->id === $ticket->id;
            }
        );
    }

    /** @test */
    public function can_not_rate_a_ticket_when_already_rated(){
        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN", "rating" => 2]);
        $response = $this->get("requester/tickets/TOKEN/rate?rating=3");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertEquals(2, $ticket->fresh()->rating);
    }


    /** @test */
    public function the_rating_email_is_sent_when_order_closed_and_not_rated()
    {
        Notification::fake();
        $requester = factory(Requester::class)->create();
        $user = factory(Admin::class)->create();
        $ticket = factory(Ticket::class)->create(["requester_id" => $requester->id, "public_token" => "TOKEN"]);

        $this->actingAs($user);
        $ticket->updateStatus(Ticket::STATUS_SOLVED);

        Notification::assertSentTo($requester, RateTicket::class,
            function ($notification, $channels) use ($ticket) {
                return $notification->ticket->id === $ticket->id;
            }
        );
    }

    /** @test */
    public function the_rating_email_is_not_sent_when_order_closed_and_rated()
    {
        Notification::fake();
        $requester = factory(Requester::class)->create();
        $user = factory(Admin::class)->create();
        $ticket = factory(Ticket::class)->create(["requester_id" => $requester->id, "public_token" => "TOKEN", "rating" => 2]);

        $this->actingAs($user);
        $ticket->updateStatus(Ticket::STATUS_SOLVED);

        Notification::assertNotSentTo($requester, RateTicket::class,
            function ($notification, $channels) use ($ticket) {
                return $notification->ticket->id === $ticket->id;
            }
        );
    }

    /** @test */
    public function it_updates_kpi(){
        Notification::fake();
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN", 'user_id' => $user->id]);
        $response = $this->get("requester/tickets/TOKEN/rate?rating=3");

        $ticket = factory(Ticket::class)->states(['closed'])->create(["public_token" => "TOKEN2", 'user_id' => $user->id]);
        $response = $this->get("requester/tickets/TOKEN2/rate?rating=2");

        $response->assertStatus(Response::HTTP_OK);
        tap (Kpi::first(), function($kpi) use($user){
            $this->assertEquals(1, $kpi->relation_id);
            $this->assertEquals(5, $kpi->total);
            $this->assertEquals(2, $kpi->count);
        });
    }


}