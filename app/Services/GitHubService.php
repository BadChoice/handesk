<?php
namespace App\Services;

use GrahamCampbell\GitHub\Facades\GitHub;
use GuzzleHttp\Client;
use App\Ticket;

/**
 * for GitHub api
 */


class GitHubService
{
    protected $repository;
    protected $username;
    const STATUS_NEW = 1;
    const STATUS_OPEN = 2;
    const STATUS_PENDING = 3;
    const STATUS_SOLVED = 4;
    const STATUS_CLOSED = 5;
    const STATUS_MERGED = 6;
    const STATUS_SPAM = 7;
    public function __construct()
    {
        $this->username=env('GITHUB_ISSUE_USERNAME', 'EATEL');
        $this->repository=env('GITHUB_ISSUE_REPOSITORY', 'Toolbox4');
    }
    public function createIssue($ticket)
    {
        try {
            $data = GitHub::connection('main')
              ->issues()
              ->create(
                $this->username,
                $this->repository,
                [
                  'title' => $ticket->title,
                  'body' => $ticket->body
                ]
            );
            if (isset($data['number'])) {
                $ticket->github_issue_id = $data['number'];
                $ticket->github_issue_uuid = $data['id'];
                $ticket->save();
                $this->addLabelToIssue($ticket->github_issue_id);
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    protected function addLabelToIssue($issue_id)
    {
        try {
            $data = GitHub::connection('main')
            ->issues()->labels()
            ->add(
                $this->username,
                $this->repository,
                $issue_id,
                'ToolBox'
            );
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
    public function updateIssue($ticket)
    {
        $state = 'open';

        if ($ticket->status==self::STATUS_SOLVED||$ticket->status==self::STATUS_CLOSED) {
            $state = 'closed';
        }
        try {
            if (($ticket->github_issue_id)) {
                $data = GitHub::connection('main')
                ->issues()
                ->update(
                  $this->username,
                  $this->repository,
                  $ticket->github_issue_id,
                  array('body' => $ticket->body,'title'=> $ticket->title, 'state' => $state)
                );
            } else {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function addComment($comment)
    {
        $issue_id = $comment->ticket->github_issue_id;
        try {
            if ($issue_id) {
                $data = GitHub::connection('main')
                ->issues()
                ->comments()
                ->create(
                  $this->username,
                  $this->repository,
                  $issue_id,
                  array('body' => $comment->body)
                );
                if (isset($data['id'])) {
                    $comment->github_comment_id = $data['id'];
                    $comment->save();
                }
            } else {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateComment($comment)
    {
        try {
            if (($comment->github_comment_id)) {
                $data = GitHub::connection('main')
                ->issues()
                ->comments()
                ->update(
                  $this->username,
                  $this->repository,
                  $comment->github_comment_id,
                  array('body' => $comment->body)
                );
            } else {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
