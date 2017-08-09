<?php

namespace Tests\Unit;

use App\Jobs\CreateTicketsFromNewEmails;
use App\Services\Pop3\FakePop3;
use App\Services\Pop3\FakePop3Message;
use App\Services\Pop3\Pop3;
use App\Ticket;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTicketsFromNewEmailsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function does_create_tickets_from_new_emails(){
        Notification::fake();
        $fakePop = new FakePop3();
        $fakePop->messages = [
            new FakePop3Message(["name" => "Bruce Wayne", "email" => "bruce@wayne.com"], "I'm batman", "Why so serious"),
            new FakePop3Message(["name" => "Jack Sparrow", "email" => "jack@sparror.com"], "The black pearl", "I'm so lost.."),
        ];
        app()->instance(Pop3::class, $fakePop);

        dispatch( new CreateTicketsFromNewEmails() );

        $this->assertEquals(2, Ticket::count());
        tap(Ticket::first(), function($ticket){
            $this->assertEquals("Bruce Wayne", $ticket->requester->name);
            $this->assertEquals("bruce@wayne.com", $ticket->requester->email);
            $this->assertEquals("I'm batman", $ticket->title);
            $this->assertEquals("Why so serious", $ticket->body);
            $this->assertEquals("email", $ticket->tags->first()->name);
        });
    }

}
