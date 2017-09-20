<?php

namespace App\Services;

class FakeIssueCreator implements IssueCreator
{
    public function createIssue($repository, $title, $body)
    {
        return (object) [
            'resource_uri' => 'https://fakeissuer.com/issue/1',
            'local_id'     => 1,
        ];
    }
}
