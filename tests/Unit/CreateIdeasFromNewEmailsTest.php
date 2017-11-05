<?php

namespace Tests\Unit;

use App\Idea;
use App\Jobs\ParseNewEmails;
use App\Services\Pop3\FakeMailbox;
use App\Services\Pop3\FakeIncomingMail;
use App\Services\Pop3\Mailbox;
use App\Ticket;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateIdeasFromNewEmailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function does_create_tickets_from_new_emails(){
        Notification::fake();
        $fakePop = new FakeMailbox();
        $fakePop->messages = [
            new FakeIncomingMail(["name" => "Bruce Wayne", "email" => "bruce@wayne.com"], "Idea: I'm batman", "Why so serious"),
            new FakeIncomingMail(["name" => "Jack Sparrow", "email" => "jack@sparrow.com"], "idea:The black pearl", "I'm so lost.."),
        ];
        app()->instance(Mailbox::class, $fakePop);

        dispatch( new ParseNewEmails() );

        $this->assertEquals(2, Idea::count());
        tap(Idea::first(), function($idea){
            $this->assertEquals("Bruce Wayne", $idea->requester->name);
            $this->assertEquals("bruce@wayne.com", $idea->requester->email);
            $this->assertEquals("I'm batman", $idea->title);
            $this->assertEquals("Why so serious", $idea->body);
            $this->assertEquals("email", $idea->tags->first()->name);
        });
    }
}
