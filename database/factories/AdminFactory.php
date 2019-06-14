<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'email_verified_at' => now(),
        'password' => 'pass',
        'remember_token' => Str::random(10),
    ];
});
