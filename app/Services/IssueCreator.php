<?php

namespace App\Services;

interface IssueCreator{

    public function createIssue($repository, $title, $body);

}