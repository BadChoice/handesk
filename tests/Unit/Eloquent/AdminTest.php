<?php

namespace Tests\Unit\Eloquent;

use App\Authenticatable\Admin;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Admin
     */
    protected $admin;

    protected function setUp() : void
    {
        parent::setUp();

        $this->admin = create(Admin::class);
    }

    /**
     * @test
     */
    public function admin_does_not_include_users()
    {
        create(User::class);

        $this->assertEquals(1, Admin::count());
        $this->assertEquals(2, User::count());
    }
}