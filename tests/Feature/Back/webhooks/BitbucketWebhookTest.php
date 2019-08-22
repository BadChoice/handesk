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
        return json_decode('{
                   "comment":{
                      "links":{
                         "self":{
                            "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app/issues/929/comments/40899645"
                         },
                         "html":{
                            "href":"https://bitbucket.org/revo-pos/revo-app/issues/929#comment-40899645"
                         }
                      },
                      "content":{
                
                      },
                      "created_on":"2017-10-30T18:36:57.848289+00:00",
                      "user":{
                         "username":"BadChoice",
                         "type":"user",
                         "display_name":"Jordi Puigdellivol",
                         "uuid":"{4f024e7b-f697-4151-81e0-1a5178f8c6d4}",
                         "links":{
                            "self":{
                               "href":"https://api.bitbucket.org/2.0/users/BadChoice"
                            },
                            "html":{
                               "href":"https://bitbucket.org/BadChoice/"
                            },
                            "avatar":{
                               "href":"https://bitbucket.org/account/BadChoice/avatar/32/"
                            }
                         }
                      },
                      "updated_on":null,
                      "type":"issue_comment",
                      "id":40899645
                   },
                   "changes":{
                      "status":{
                         "new":"'.$newStatus.'",
                         "old":"new"
                      }
                   },
                   "issue":{
                      "content":{
                         "raw":"Falta concretar",
                         "markup":"markdown",
                         "html":"<p>Falta concretar</p>"
                      },
                      "kind":"enhancement",
                      "repository":{
                         "full_name":"revo-pos/revo-app",
                         "type":"repository",
                         "name":"revo-app",
                         "links":{
                            "self":{
                               "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app"
                            },
                            "html":{
                               "href":"https://bitbucket.org/revo-pos/revo-app"
                            },
                            "avatar":{
                               "href":"https://bitbucket.org/revo-pos/revo-app/avatar/32/"
                            }
                         },
                         "uuid":"{2d83eefb-f6b3-4d4f-a2cf-44aecfb04005}"
                      },
                      "links":{
                         "attachments":{
                            "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app/issues/929/attachments"
                         },
                         "self":{
                            "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app/issues/929"
                         },
                         "watch":{
                            "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app/issues/929/watch"
                         },
                         "comments":{
                            "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app/issues/929/comments"
                         },
                         "html":{
                            "href":"https://bitbucket.org/revo-pos/revo-app/issues/929/promos-autom-tiques"
                         },
                         "vote":{
                            "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app/issues/929/vote"
                         }
                      },
                      "title":"Promos autom\u00e0tiques",
                      "reporter":{
                         "username":"BadChoice",
                         "type":"user",
                         "display_name":"Jordi Puigdellivol",
                         "uuid":"{4f024e7b-f697-4151-81e0-1a5178f8c6d4}",
                         "links":{
                            "self":{
                               "href":"https://api.bitbucket.org/2.0/users/BadChoice"
                            },
                            "html":{
                               "href":"https://bitbucket.org/BadChoice/"
                            },
                            "avatar":{
                               "href":"https://bitbucket.org/account/BadChoice/avatar/32/"
                            }
                         }
                      },
                      "component":null,
                      "votes":0,
                      "watches":1,
                      "priority":"major",
                      "assignee":null,
                      "state":"'.$newStatus.'",
                      "version":{
                         "name":"2.0",
                         "links":{
                            "self":{
                               "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app/versions/222766"
                            }
                         }
                      },
                      "edited_on":null,
                      "created_on":"2017-09-14T11:09:49.630392+00:00",
                      "milestone":null,
                      "updated_on":"2017-10-30T18:36:57.825625+00:00",
                      "type":"issue",
                      "id":'.$issueId.'
                   },
                   "actor":{
                      "username":"BadChoice",
                      "type":"user",
                      "display_name":"Jordi Puigdellivol",
                      "uuid":"{4f024e7b-f697-4151-81e0-1a5178f8c6d4}",
                      "links":{
                         "self":{
                            "href":"https://api.bitbucket.org/2.0/users/BadChoice"
                         },
                         "html":{
                            "href":"https://bitbucket.org/BadChoice/"
                         },
                         "avatar":{
                            "href":"https://bitbucket.org/account/BadChoice/avatar/32/"
                         }
                      }
                   },
                   "repository":{
                      "scm":"git",
                      "website":"http://www.revo.works/",
                      "name":"'.$repository.'",
                      "links":{
                         "self":{
                            "href":"https://api.bitbucket.org/2.0/repositories/revo-pos/revo-app"
                         },
                         "html":{
                            "href":"https://bitbucket.org/revo-pos/revo-app"
                         },
                         "avatar":{
                            "href":"https://bitbucket.org/revo-pos/revo-app/avatar/32/"
                         }
                      },
                      "project":{
                         "links":{
                            "self":{
                               "href":"https://api.bitbucket.org/2.0/teams/revo-pos/projects/XEF"
                            },
                            "html":{
                               "href":"https://bitbucket.org/account/user/revo-pos/projects/XEF"
                            },
                            "avatar":{
                               "href":"https://bitbucket.org/account/user/revo-pos/projects/XEF/avatar/32"
                            }
                         },
                         "type":"project",
                         "uuid":"{4240b083-ceac-4940-9ecc-9d2b903017bc}",
                         "key":"XEF",
                         "name":"RevoXef"
                      },
                      "full_name":"revo-pos/revo-app",
                      "owner":{
                         "username":"revo-pos",
                         "type":"team",
                         "display_name":"Revo",
                         "uuid":"{6fa4ada1-2d50-4aaf-94bc-5fffb9d4504f}",
                         "links":{
                            "self":{
                               "href":"https://api.bitbucket.org/2.0/teams/revo-pos"
                            },
                            "html":{
                               "href":"https://bitbucket.org/revo-pos/"
                            },
                            "avatar":{
                               "href":"https://bitbucket.org/account/revo-pos/avatar/32/"
                            }
                         }
                      },
                      "type":"repository",
                      "is_private":true,
                      "uuid":"{2d83eefb-f6b3-4d4f-a2cf-44aecfb04005}"
                   }
                }', true);
    }

    /** @test */
    public function can_receive_a_resolved_issue_and_ticket_is_updated()
    {
        Notification::fake();
        $payload = $this->getPayload(929, "revo-pos/revo-app", 'resolved');

        $this->actingAs(factory(Admin::class)->create());
        $ticket = factory(Ticket::class)->create();
        $ticket->createIssue(new FakeIssueCreator(929), "revo-pos/revo-app");
        $this->assertCount(1, $ticket->fresh()->commentsAndNotes);

        $response = $this->post('webhook/bitbucket', $payload);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(2, $ticket->fresh()->commentsAndNotes);
        $this->assertEquals("Issue status updated to resolved", $ticket->commentsAndNotes[1]->body);
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

                $response = $this->call('POST','webhook/bitbucket', [], [], [], [], $payload);

                $response->assertStatus(Response::HTTP_OK);
                $this->assertCount(2, $ticket->fresh()->commentsAndNotes);
            }

}
