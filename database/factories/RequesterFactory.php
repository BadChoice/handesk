<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Requester;

$factory->define(Requester::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->name,
        'email' => $faker->safeEmail,
    ];
});