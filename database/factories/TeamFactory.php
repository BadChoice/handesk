<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Team;

$factory->define(Team::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->word,
        'token' => str_random(24),
    ];
});
