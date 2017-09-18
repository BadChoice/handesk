<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Lead;
use App\Task;

$factory->define(Task::class, function (Faker\Generator $faker) {
    return [
        'body'    => $faker->sentence(),
        'lead_id' => factory(Lead::class),
    ];
});
