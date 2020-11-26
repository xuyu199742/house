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

$factory->define(App\Models\Housetype::class, function (Faker $faker) {
    $bedroom     = rand(1, 3);
    $living_room = rand(1, 2);
    $area        = rand(60, 250);

    return [
        'title'            => $bedroom . '室' . $living_room . '厅',
        'sale_status'      => $faker->randomElement(\App\Models\Housetype::SALE_STATUS),
        'area'             => $area,
        'real_area'        => round($area * 0.83),
        'bedroom_count'    => $bedroom,
        'livingroom_count' => $living_room,
        'photos'           => ['/images/housetype/' . rand(1, 5) . '.jpg', '/images/housetype/' . rand(1, 5) . '.jpg'],
    ];
});
