<?php

namespace Tests\Feature;

use App\Authenticatable\Admin;
use App\Idea;
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

class IdeaIssueTest extends TestCase
{
    use RefreshDatabase;

    private function setIssueCreatorMock($id = 12){
        $issueCreator = Mockery::mock(Bitbucket::class);
        $issueCreator->shouldReceive('createIssue')->andReturn( (object)[
            "id"      => 12,
            "resource_uri"  => "1.0/repositories/issues/12",
            "links" => (object)["self" => (object)["href" => "http://fakeurl"]]
        ] );
        app()->instance(IssueCreator::class, $issueCreator);
    }

    /** @test */
    public function can_create_issue_from_idea(){
        Notification::fake();
        $user   = factory(Admin::class)->create();
        $idea = factory(Idea::class)->create([
            "repository" => "test/repo"
        ]);

        $this->setIssueCreatorMock(12);

        $response = $this->actingAs($user)->post("ideas/{$idea->id}/issue");

        $response->assertStatus( Response::HTTP_FOUND );
        $this->assertEquals(12, $idea->fresh()->issue_id );
    }

    /** @test */
    public function non_admin_cannot_create_issue_from_ticket(){
        $user   = factory(User::class)->create();
        $idea = factory(Idea::class)->create([
            "repository" => "fake/repo"
        ]);

        $response = $this->actingAs($user)->post("ideas/{$idea->id}/issue");

        $response->assertStatus( Response::HTTP_FORBIDDEN );
    }

    /** @test */
    public function issue_can_not_be_created_twice(){
        Notification::fake();
        $user   = factory(Admin::class)->create();
        $idea = factory(Idea::class)->create([
            "repository" => "fake/repo",
            "issue_id" => 10
        ]);

        $this->setIssueCreatorMock(12);

        $response = $this->actingAs($user)->post("ideas/{$idea->id}/issue");

        $response->assertStatus( Response::HTTP_INTERNAL_SERVER_ERROR );
        $this->assertEquals(10, $idea->fresh()->issue_id );
    }
}