<?php

namespace Tests\Unit\Eloquent;

use App\Authenticatable\Admin;
use App\Authenticatable\Assistant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssistantTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Assistant
     */
    protected $assistant;

    protected function setUp() : void
    {
        parent::setUp();

        $this->assistant = create(Assistant::class);
    }

    /**
     * @test
     */
    public function assistant_does_not_include_users()
    {
        create(User::class);

        $this->assertEquals(1, Assistant::count());
        $this->assertEquals(2, User::count());
    }
}