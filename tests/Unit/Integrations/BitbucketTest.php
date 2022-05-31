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
        $driver = config('issues.credentials.driver');
        if (! $driver) {
            $this->markTestSkipped('Bitbucket not configured');
        }

        // not added to config as this is only used for testing
        $repo = env('BITBUCKET_REPOSITORY', 'revo-pos/revo-back');
        $issue = (new Bitbucket)->createIssue($repo, 'test issue', 'this is a test issue', 'test');
        $this->assertTrue(is_numeric($issue->id));
    }
}
