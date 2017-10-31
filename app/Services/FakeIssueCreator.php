<?php

namespace App\Services;

class FakeIssueCreator implements IssueCreator
{
    private $id;

    public function __construct($id = 1)
    {
        $this->id = $id;
    }

    public function createIssue($repository, $title, $body)
    {
        return (object) [
            'resource_uri' => "https://fakeissuer.com/issue/{$this->id}",
            'local_id'     => $this->id,
        ];
    }
}
