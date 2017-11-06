<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Idea;
use App\Requester;

$factory->define(Idea::class, function (Faker\Generator $faker) {
    return [
        'requester_id' => factory(Requester::class),
        'title'        => $faker->sentence,
        'body'         => $faker->paragraph(4),
        'status'       => Idea::STATUS_NEW,
    ];
});
