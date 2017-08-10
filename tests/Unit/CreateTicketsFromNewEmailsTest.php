<?php

namespace Tests\Unit;

use App\Jobs\CreateTicketsFromNewEmails;
use App\Requester;
use App\Services\Pop3\FakePop3;
use App\Services\Pop3\FakePop3Message;
use App\Services\Pop3\Pop3;
use App\Services\Pop3\Pop3MessageCommentParser;
use App\Ticket;
use App\User;
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
        $agent                              = factory(User::class)     ->create(["email" => "tony@stark.com"]);
        $ticketWithCommentRequester         = factory(Requester::class)->create(["email" => "peter@parker.com"]);
        $ticketThatWillGetTheCommentByMail  = factory(Ticket::class)   ->create(["id" => 18, "requester_id" => $ticketWithCommentRequester ]);
        $ticketReplyBody = "The email reply:: Reply above this line ::</span>\r\n\r\nA new comment for the ticket\r\n\r\nAaaaand another one\r\n\r\nSee the ticket\r\nThank you for using our application!\r\n\r\nticket-id:18.</span>\r\n\r\nRegards,\r\nHandesk\r\n\r\nIf you’re having trouble clicking the \"See the ticket\" button, copy and paste the URL below into your web browser: http://handesk.dev/requester/tickets/eQDXxiSRwPwS0tFGpj9jQJH2\r\n\r\n© 2017 Handesk. All rights reserved. ticket-id:19.";
        $fakePop->messages = [
            new FakePop3Message(["name" => "Bruce Wayne", "email" => "bruce@wayne.com"], "I'm batman", "Why so serious"),
            new FakePop3Message(["name" => "Jack Sparrow", "email" => "jack@sparrow.com"], "The black pearl", "I'm so lost.."),
            new FakePop3Message(["name" => "Jack Sparrow", "email" => "tony@stark.com"], "Reply to of ticket", $ticketReplyBody    ),
            new FakePop3Message(["name" => "Peter Parker", "email" => "peter@parker.com"], "Reply to of ticket 2", $ticketReplyBody    ),
        ];
        app()->instance(Pop3::class, $fakePop);

        dispatch( new CreateTicketsFromNewEmails() );

        $this->assertEquals(3, Ticket::count());
        tap(Ticket::all()[1], function($ticket){
            $this->assertEquals("Bruce Wayne", $ticket->requester->name);
            $this->assertEquals("bruce@wayne.com", $ticket->requester->email);
            $this->assertEquals("I'm batman", $ticket->title);
            $this->assertEquals("Why so serious", $ticket->body);
            $this->assertEquals("email", $ticket->tags->first()->name);
        });

        $this->assertCount(2, $ticketThatWillGetTheCommentByMail->comments);
        tap($ticketThatWillGetTheCommentByMail->comments->first(), function($comment){
            $this->assertEquals("The email reply", $comment->body);
            $this->assertEquals("tony@stark.com", $comment->user->email);
        });

        tap($ticketThatWillGetTheCommentByMail->comments->last(), function($comment){
            $this->assertEquals("The email reply", $comment->body);
            $this->assertNull($comment->user);
        });
    }
    
    /** @test */
    public function can_detect_replies_as_comments(){
        $newTicketBody      = "This is a new ticket body";
        $ticketReplyBody    = "Here comes my fresh comment\r\n\r\nJordi Puigdellívol\r\nCTO\r\\r\n\r\njordi.p@revo.works | \t\twww.revo.works\r\nEncès 10 d’agost de 2017 a 21:43:35, Codepassion (hello@codepassion.io) va escriure:\r\n\r\nHandesk\r\n:: Reply above this line ::</span>\r\n\r\nA new comment for the ticket\r\n\r\nAaaaand another one\r\n\r\nSee the ticket\r\nThank you for using our application!\r\n\r\nticket-id:18.</span>\r\n\r\nRegards,\r\nHandesk\r\n\r\nIf you’re having trouble clicking the \"See the ticket\" button, copy and paste the URL below into your web browser: http://handesk.dev/requester/tickets/eQDXxiSRwPwS0tFGpj9jQJH2\r\n\r\n© 2017 Handesk. All rights reserved. ticket-id:19.";

        $parser1 = new Pop3MessageCommentParser( new FakePop3Message(["name" => "Bruce Wayne", "email" => "bruce@wayne.com"], "I'm batman", $newTicketBody) );
        $parser2 = new Pop3MessageCommentParser( new FakePop3Message(["name" => "Jack Sparrow", "email" => "jack@sparrow.com"], "The black pearl", $ticketReplyBody) );

        $this->assertFalse( $parser1->isAComment() );
        $this->assertTrue(  $parser2->isAComment() );
        $this->assertEquals("Here comes my fresh comment\r\n\r\nJordi Puigdellívol\r\nCTO\r\\r\n\r\njordi.p@revo.works | \t\twww.revo.works\r\nEncès 10 d’agost de 2017 a 21:43:35, Codepassion (hello@codepassion.io) va escriure:\r\n\r\nHandesk\r\n",
                            $parser2->getCommentBody());
        $this->assertEquals(18, $parser2->getTicketId());
    }

    /** @test */
    public function comment_parser_returns_null_user_if_is_the_requester(){
        $user       = factory(User::class)->create(["email" => "james@bond.com"]);
        $requester  = factory(Requester::class)->create(["email" => "james@bond.com"]);
        $ticket     = factory(Ticket::class)->create(["requester_id" => $requester->id]);
        $parser1    = new Pop3MessageCommentParser( new FakePop3Message(["name" => "Bruce Wayne", "email" => "james@bond.com"], "I'm batman", ":: Reply above this line :: ticket-id:1.") );

        $this->assertNull($parser1->getUser( $ticket ));
    }

    /** @test */
    public function comment_parser_returns_the_user_if_it_is_not_the_requester(){
        $user       = factory(User::class)->create(["email" => "bruce@wayne.com"]);
        $requester  = factory(Requester::class)->create(["email" => "james@bond.com"]);
        $ticket     = factory(Ticket::class)->create(["requester_id" => $requester->id]);
        $parser1    = new Pop3MessageCommentParser( new FakePop3Message(["name" => "Bruce Wayne", "email" => "bruce@wayne.com"], "I'm batman", ":: Reply above this line :: ticket-id:1.") );

        $this->assertEquals("bruce@wayne.com", $parser1->getUser( $ticket )->email);
    }

    /** @test */
    public function comment_parser_returns_null_if_it_is_an_unknown_email(){
        $requester  = factory(Requester::class)->create(["email" => "james@bond.com"]);
        $ticket     = factory(Ticket::class)->create(["requester_id" => $requester->id]);
        $parser1    = new Pop3MessageCommentParser( new FakePop3Message(["name" => "Bruce Wayne", "email" => "unkown@bond.com"], "I'm batman", ":: Reply above this line :: ticket-id:1.") );

        $this->assertNull($parser1->getUser( $ticket ));
    }
}
