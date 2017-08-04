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
use App\Requester;
use App\Team;
use App\Ticket;
use function foo\func;

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
        "requester_id" => function(){
            return factory(Requester::class)->create()->id;
        },
        "title"         => $faker->sentence,
        "body"          => $faker->paragraph(4),
        "status"        => Ticket::STATUS_NEW,
        "public_token"  => str_random(24),
    ];
});

$factory->define(Requester::class, function(Faker\Generator $faker){
    return [
        "name" => $faker->name,
        "email" => $faker->safeEmail,
    ];
});
$factory->define(Team::class, function(Faker\Generator $faker){
    return [
        "name" => $faker->word,
    ];
});