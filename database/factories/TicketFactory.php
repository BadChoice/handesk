<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Ticket;
use App\Requester;

$factory->define(Ticket::class, function (Faker\Generator $faker) {
    return [
        'requester_id' => factory(Requester::class),
        'title'        => $faker->sentence,
        'body'         => $faker->paragraph(4),
        'status'       => Ticket::STATUS_NEW,
        'public_token' => str_random(24),
    ];
});
