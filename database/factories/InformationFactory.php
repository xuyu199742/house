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

$factory->define(App\Models\Information::class, function (Faker $faker) {
    return [
        'title'      => $faker->randomElement([
            '面积约99、121㎡，目前有优惠',
            '公证摇号结果出炉',
            '新领324套房源销许',
            '预计近期首开高层16、17、21号楼',
            '公开售楼处样板间'
        ]),
        'type'       => $faker->randomElement([
            '房源新闻',
            '预售开盘',
            '摇号选房'
        ]),
        'content'    => '在售高层16、17、21号楼，销售均价约29800元/㎡，具体一房一价，建筑面积约99、121㎡，一梯一户，精装交付，拟交付时间2021年6月30日。',
        'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
        'media_id'   => rand(1, 10)
    ];
});
