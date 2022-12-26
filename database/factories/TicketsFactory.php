<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tickets;
use Faker\Generator as Faker;

$factory->define(Tickets::class, function (Faker $faker) {
    return [
        'id' => factory(\App\User::class),
        'created_by' => $faker->word,
        'importance' => $faker->word,
        'title' => $faker->word,
        'status' => $faker->word
    ];
});
