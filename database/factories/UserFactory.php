<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->state(User::class, 'admin', function ($faker) {
    return [
        'admin' => 1,
    ];
});

$factory->state(User::class, 'assistant', function ($faker) {
    return [
        'assistant' => 1,
    ];
});
