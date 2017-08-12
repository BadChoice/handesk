<?php

namespace Tests\Feature;

use App\Team;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_see_profile(){
        $user = factory(User::class)->create(["name" => "Sexy Girl"]);

        $response = $this->actingAs($user)->get('profile');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("Sexy Girl");
    }

    /** @test */
    public function can_update_profile(){
        $user = factory(User::class)->create(["name" => "Sexy Girl"]);

        $response = $this->actingAs($user)->put('profile',["name" => "Sexy boy"]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals("Sexy boy", $user->fresh()->name);
    }

    /** @test */
    public function can_update_password(){
        $user = factory(User::class)->create(["name" => "Sexy Girl", "password" => bcrypt("secret")]);

        $response = $this->actingAs($user)->post('password',[
            "old"                   => "secret",
            "password"              => "hello",
            "password_confirmation" => "hello",
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue( \Hash::check("hello", $user->fresh()->password) );
    }

    /** @test */
    public function can_not_update_password_if_old_is_wrong(){
        $user = factory(User::class)->create(["name" => "Sexy Girl", "password" => bcrypt("secret")]);

        $response = $this->actingAs($user)->post('password',[
            "old"                   => "wrong_old_password",
            "password"              => "hello",
            "password_confirmation" => "hello",
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue( \Hash::check("secret", $user->fresh()->password) );
    }

    public function can_not_update_password_if_new_not_confirmed(){
        $user = factory(User::class)->create(["name" => "Sexy Girl", "password" => bcrypt("secret")]);

        $response = $this->actingAs($user)->post('password',[
            "old"                   => "secret",
            "password"              => "hello",
            "password_confirmation" => "wrong_confirmation",
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue( \Hash::check("secret", $user->fresh()->password) );
    }
}