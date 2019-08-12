<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\ReportTag;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(ReportTag::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'taxonomy' => 'place',
    ];
});
