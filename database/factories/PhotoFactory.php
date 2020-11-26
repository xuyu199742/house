<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(App\Models\Photo::class, function (Faker $faker) {
    return [
        'category' => $faker->randomElement(\App\Models\Photo::CATEGORIES),
        'url' => '/images/house/'.rand(0,18).'.jpg',
    ];
});
