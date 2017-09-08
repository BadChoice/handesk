<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Ticket;
use App\Comment;

$factory->define(Comment::class, function (Faker\Generator $faker) {
    return [
        'body'       => $faker->paragraph,
        'new_status' => Ticket::STATUS_OPEN,
    ];
});
