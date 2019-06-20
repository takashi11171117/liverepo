<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Report;
use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\Models\User::class)->create()->id,
        'title'   => $faker->realText(100),
        'content' => $faker->realText(3000),
        'status'  => rand(0, 2),
        'rating'  => rand(1, 5),
    ];
});
