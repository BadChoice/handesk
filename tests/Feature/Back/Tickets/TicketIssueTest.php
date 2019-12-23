<?php

namespace Tests\Feature;

use App\Notifications\NewComment;
use App\Notifications\TicketEscalated;
use App\Services\Bitbucket\Bitbucket;
use App\Services\IssueCreator;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Mockery\Mock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketIssueTest extends TestCase
{
    use RefreshDatabase;

    private function setIssueCreatorMock(){
        $issueCreator = Mockery::mock(Bitbucket::class);
        $issueCreator->shouldReceive('createIssue')->andReturn( (object)[
            "id"      => 12,
            "resource_uri"  => "1.0/repositories/issues/12",
            "links" => (object)["self" => (object)["href" => "http://fakeurl"]]
        ] );
        app()->instance(IssueCreator::class, $issueCreator);
    }

    /** @test */
    public function can_create_issue_from_ticket(){
        Notification::fake();
        $user   = factory(User::class)->states(["admin"])->create();
        $ticket = factory(Ticket::class)->create([
            "subject" => "subject",
            "summary" => "summary",
        ]);

        $this->setIssueCreatorMock();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/issue",[
            "repository" => "test/repo"
        ]);

        $response->assertStatus( Response::HTTP_FOUND );
        $this->assertEquals(1, $ticket->fresh()->commentsAndNotes->count() );
        $this->assertContains("#12", $ticket->fresh()->commentsAndNotes->first()->body);
    }

    /** @test */
    public function non_admin_cannot_create_issue_from_ticket(){
        $user   = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/issue",[
            "repository" => "test/repo"
        ]);

        $response->assertStatus( Response::HTTP_FORBIDDEN );
    }

    /** @test */
    public function issue_can_not_be_created_twice(){
        Notification::fake();
        $user   = factory(User::class)->states(["admin"])->create();
        $ticket = factory(Ticket::class)->create([
            "subject" => "subject",
            "summary" => "summary",
        ]);

        $this->setIssueCreatorMock();

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/issue",[
            "repository" => "test/repo"
        ]);

        $response->assertStatus( Response::HTTP_FOUND );
        $this->assertEquals(1, $ticket->fresh()->commentsAndNotes->count() );

        $response = $this->actingAs($user)->post("tickets/{$ticket->id}/issue",[
            "repository" => "test/repo"
        ]);
        $response->assertStatus( Response::HTTP_INTERNAL_SERVER_ERROR );
        $this->assertEquals(1, $ticket->fresh()->commentsAndNotes->count() );
    }
}