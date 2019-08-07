<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->email,
        'email_verified_at' => now(),
        'password' => '3387Ezweb',
        'remember_token' => Str::random(10),
    ];
});
