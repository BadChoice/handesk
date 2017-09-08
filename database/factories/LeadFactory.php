<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Lead;

$factory->define(Lead::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->word,
        'email' => $faker->safeEmail,
    ];
});
