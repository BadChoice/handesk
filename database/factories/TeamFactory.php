<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Team;
use Illuminate\Support\Str;

$factory->define(Team::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->word,
        'token' => Str::random(24),
    ];
});
