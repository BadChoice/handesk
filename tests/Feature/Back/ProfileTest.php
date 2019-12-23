<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    protected function setUp()  : void
    {
        parent::setUp();

        $this->actingAs($this->user = factory(User::class)->create());
    }

    /** @test */
    public function can_see_profile()
    {
        $response = $this->get('profile');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee(e($this->user->name));
    }

    /** @test */
    public function can_update_profile()
    {
        $name = 'Sexy boy';
        $response = $this->put('profile', ['name' => $name, 'locale' => 'en']);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals('Sexy boy', $this->user->fresh()->name);
    }

    /** @test */
    public function can_update_password()
    {
        $response = $this->post('password', [
            'old' => 'secret',
            'password' => 'hello',
            'password_confirmation' => 'hello',
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue(Hash::check('hello', $this->user->fresh()->password));
    }

    /** @test */
    public function can_not_update_password_if_old_is_wrong()
    {
        $response = $this->post('password', [
            'old' => 'wrong_old_password',
            'password' => 'hello',
            'password_confirmation' => 'hello',
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue(Hash::check('secret', $this->user->fresh()->password));
    }

    /** @test */
    public function can_not_update_password_if_new_not_confirmed()
    {
        $response = $this->post('password', [
            'old' => 'secret',
            'password' => 'hello',
            'password_confirmation' => 'wrong_confirmation',
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue(Hash::check('secret', $this->user->fresh()->password));
    }

    /**
     * @test
     */
    public function can_change_signature()
    {
        $signature = 'This is my new signature.';

        $response = $this->put(route('profile.update'), [
            'name' => 'Sexy boy',
            'locale' => 'en',
            'tickets_signature'=> $signature
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($signature, $this->user->fresh()->settings->tickets_signature);
    }

    /**
     * @test
     * @dataProvider toggableNotifications
     * @param string $notification
     */
    public function can_turn_on_notification($notification)
    {
        $response = $this->put(route('profile.update'), [
            'name' => 'Sexy boy',
            'locale' => 'en',
            $notification => true
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue(!!$this->user->fresh()->settings->{$notification});
    }

    /**
     * @test
     * @dataProvider toggableNotifications
     * @param string $notification
     */
    public function can_turn_off_notification($notification)
    {
        $this->user->settings()->updateOrCreate([], [$notification => 1]);

        $response = $this->put(route('profile.update'), [
            'name' => 'Sexy boy',
            'locale' => 'en'
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertFalse(!!$this->user->fresh()->settings->{$notification});
    }

    public function toggableNotifications()
    {
        return [
            ['new_ticket_notification'],
            ['ticket_assigned_notification'],
            ['ticket_updated_notification'],
            ['new_lead_notification'],
            ['lead_assigned_notification'],
            ['daily_tasks_notification']
        ];
    }
}