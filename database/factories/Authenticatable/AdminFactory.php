<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Authenticatable\Admin;

$factory->define(Admin::class, function (Faker\Generator $faker) {
    return ['admin' => 1] + factory(\App\User::class)->raw();
});
