<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Authenticatable\Assistant;

$factory->define(Assistant::class, function (Faker\Generator $faker) {
    return ['assistant' => 1] + factory(\App\User::class)->raw();
});
