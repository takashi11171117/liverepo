<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\ReportImage;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(ReportImage::class, function (Faker $faker) {

    $filename = 'dummy' . Str::random(40) .'.jpg';
    $thumbnail = 'thumb-' . $filename;
    Storage::disk('s3');
    UploadedFile::fake()->image($filename, 1200, 300)
        ->storeAs('report_images', $filename, ['disk' => 's3']);
    UploadedFile::fake()->image($thumbnail, 300, 300)
                        ->storeAs('report_images', $thumbnail, ['disk' => 's3']);

    return [
        'path' => $filename
    ];
});
