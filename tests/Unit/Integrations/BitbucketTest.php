<?php

namespace Tests\Unit\Integrations;

use App\Services\Bitbucket\Bitbucket;
use Tests\TestCase;

/** @group integrations */
class BitbucketTest extends TestCase
{
    /** @test */
    public function can_create_issue()
    {
        $driver = config('issue.credentials.driver');
        if (! $driver) {
            $this->markTestSkipped('Bitbucket not configured');
        }

        $repo = 'revo-pos/revo-back';
        $issue = (new Bitbucket)->createIssue($repo, 'test issue', 'this is a test issue');
        $this->assertTrue(is_numeric($issue->id));
    }
}