<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Team;
use App\Ticket;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Ticket::class, function(Faker\Generator $faker){
    return [
        "requester" => $faker->word,
        "title" => $faker->sentence,
        "body" => $faker->paragraph(4),
        "status" => Ticket::STATUS_NEW,
    ];
});

$factory->define(Team::class, function(Faker\Generator $faker){
    return [
        "name" => $faker->word,
    ];
});