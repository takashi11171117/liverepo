<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\ReportComment;
use Faker\Generator as Faker;

$factory->define(ReportComment::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\Models\User::class)->create()->id,
        'body'   => $faker->realText(100),
    ];
});
