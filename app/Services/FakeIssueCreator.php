<?php

namespace App\Services;

class FakeIssueCreator implements IssueCreator
{
    private $id;

    public function __construct($id = 1)
    {
        $this->id = $id;
    }

    public function createIssue($account, $repoSlug, $title, $content, $extra = [])
    {
        return (object) [
            'resource_uri'  => "https://fakeissuer.com/issue/{$this->id}",
            'id'            => $this->id,
        ];
    }

    public function createComment($account, $repoSlug, $id, $comment)
    {
    }

    public function updateIssue($account, $repoSlug, $id, $fields)
    {
    }
}
