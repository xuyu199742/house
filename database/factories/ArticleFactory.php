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

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'category' => $faker->randomElement([
            '房源信息',
            '政策动态',
        ]),
        'content' => $faker->paragraph,
        'media_id' => rand(1,10),
        'created_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
