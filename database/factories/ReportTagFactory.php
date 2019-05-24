<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ReportTag;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(ReportTag::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'taxonomy' => 'place',
    ];
});
