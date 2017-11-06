<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Services\IssueCreator;

class IdeaIssueController extends Controller
{
    public function store(IssueCreator $issueCreator, Idea $idea)
    {
        $this->authorize('create-issue', $idea);
        $this->validateIssueNotAlreadyCreated($idea);
        $idea->createIssue($issueCreator);

        return back();
    }

    private function validateIssueNotAlreadyCreated($idea)
    {
        if ($idea->issue_id) {
            throw new \Exception('Issue already created');
        }
    }
}
