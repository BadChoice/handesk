<?php

namespace App\Services;

interface IssueCreator
{
    public function createIssue($account, $repoSlug, $title, $content, $extra = []);

    public function createComment($account, $repoSlug, $id, $comment);

    public function updateIssue($account, $repoSlug, $id, $fields);
}
