<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Type;

$factory->define(Type::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->company,
    ];
});