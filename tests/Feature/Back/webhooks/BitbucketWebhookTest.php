<?php

namespace Tests\Feature;

use App\Authenticatable\Admin;
use App\Idea;
use App\Services\FakeIssueCreator;
use App\Services\IssueCreator;
use App\Ticket;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BitbucketWebhookTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    private function getPayload($issueId, $repository, $newStatus = 'open'){
        $json = file_get_contents(base_path() . '/tests/Feature/Back/webhooks/bitbucket_payload.json');
        $json = str_replace("{{issueId}}",      $issueId, $json);
        $json = str_replace("{{repository}}",   $repository, $json);
        $json = str_replace("{{newStatus}}",    $newStatus, $json);
        return json_decode($json, true);
    }

    /** @test */
    public function can_receive_a_resolved_issue_and_ticket_is_updated()
    {
        $this->withoutExceptionHandling();
        Notification::fake();
        $payload = $this->getPayload(929, "revo-pos/revo-app", 'resolved');

        $this->actingAs(factory(Admin::class)->create());
        $ticket = factory(Ticket::class)->create();
        $ticket->createIssue(new FakeIssueCreator(929), "revo-pos/revo-app");
        $this->assertCount(1, $ticket->fresh()->commentsAndNotes);

        $response = $this->post('webhook/bitbucket', $payload);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(2, $ticket->fresh()->commentsAndNotes);
        $this->assertEquals("Issue status updated to resolved: ", $ticket->commentsAndNotes[1]->body);
    }

     /** @test */
      public function a_not_resolved_issue_updates_status()
      {
          $payload = $this->getPayload(929, "revo-pos/revo-app", 'open');

          $this->actingAs(factory(Admin::class)->create());
          $ticket = factory(Ticket::class)->create();
          $ticket->createIssue(new FakeIssueCreator(929), "revo-pos/revo-app");
          $this->assertCount(1, $ticket->fresh()->commentsAndNotes);

          $response = $this->post('webhook/bitbucket', $payload);

          $response->assertStatus(Response::HTTP_OK);
          $this->assertCount(2, $ticket->fresh()->commentsAndNotes);
      }

       /** @test */
        public function receiving_an_update_of_a_non_existing_issue_or_idea_does_not_crash()
        {
            $payload = $this->getPayload(929, "revo-app", 'resolved');

            $response = $this->post('webhook/bitbucket', $payload);

            $response->assertStatus(Response::HTTP_OK);
        }

         /** @test */
          public function receiving_an_invalid_payload_does_not_crash()
          {
              $response = $this->post('webhook/bitbucket', ["invalid" => "this is an invalid payload"]);
              $response->assertStatus(Response::HTTP_OK);
          }

           /** @test */
            public function can_update_idea_status_from_webhook()
            {
                $idea = factory(Idea::class)->create([
                    "repository" => "revo-pos/revo-app",
                    "issue_id" => 929,
                    "status" => Idea::STATUS_OPEN,
                ]);

                $payload = $this->getPayload(929, "revo-app", 'closed');

                $response = $this->post('webhook/bitbucket', $payload);

                $response->assertStatus(Response::HTTP_OK);
                $this->assertEquals(Idea::STATUS_CLOSED, $idea->fresh()->status);
            }

            /** @test */
            public function can_parse_a_null_comment()
            {
                $payload = file_get_contents(base_path() . "/tests/Feature/Back/webhooks/null_content_webhook_payload.json");
                $this->actingAs(factory(Admin::class)->create());
                $ticket = factory(Ticket::class)->create();
                $ticket->createIssue(new FakeIssueCreator(513), "revo-pos/revo-retail");
                $this->assertCount(1, $ticket->fresh()->commentsAndNotes);

                $response = $this->call('POST','webhook/bitbucket', [], [], [], ["HTTP_Content-Type" => "application/json"], $payload);

                $response->assertStatus(Response::HTTP_OK);
                $this->assertCount(2, $ticket->fresh()->commentsAndNotes);
            }

}
