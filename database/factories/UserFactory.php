<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $filename = 'user' . Str::random(40) .'.jpg';
    $thumbnail = 'thumb-' . $filename;
    Storage::disk('s3');
    UploadedFile::fake()->image($filename, 300, 300)
                ->storeAs('profile_images', $filename, ['disk' => 's3']);
    UploadedFile::fake()->image($thumbnail, 80, 80)
                ->storeAs('profile_images', $thumbnail, ['disk' => 's3']);

    return [
        'name' => $faker->unique()->word,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '3387Ezweb',
        'remember_token' => Str::random(10),
        'birth' => $faker->dateTimeBetween('-80 years', '-20years')->format('Y-m-d'),
        'gender' => rand(0, 1),
        'pref' => rand(1, 47),
        'show_mail_flg' => rand(0, 1),
        'user_name01' => $faker->firstName,
        'user_name02' => $faker->lastName,
        'url' => $faker->url,
        'description' => $faker->realText(200),
        'image_path' => $filename,
    ];
});
