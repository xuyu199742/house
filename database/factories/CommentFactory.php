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

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'avatar' => '/images/avatar/avatar-'.rand(1,10).'.jpg',
        'nickname' => $faker->name,
        'content' =>  $faker->randomElement([
            '周边有什么学校吗?',
            '现在价格大概多少? 有没有优惠了?',
            '这个房源的学区是什么?',
            '我最近去看了一下, 售楼处的态度不要太吊, 真的是不愁卖啊?'
        ]),
        'user_id' => 2,
        'created_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
