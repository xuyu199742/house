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

$factory->define(App\Models\Question::class, function (Faker $faker) {
    return [
        'content' => '这个楼盘怎么样? 附近有什么配套吗?',
        'answer' => $faker->boolean ?  '融信城市之窗位于秣陵街道双龙大道，距地铁3号线东大九龙湖校区站仅50米,还有规划的5号线也从此经过，站口地下可直通公寓。规划地下商场，位于九龙湖商圈，距百家湖商圈3.9公里,往南3公里砂之船奥特莱斯，马路对面同仁医院，交通便利，生活配套成熟。': '',
        'hot' => $faker->boolean,
        'view_count' => rand(100, 9999),
        'user_name' => $faker->name,
        'user_avatar' => $faker->imageUrl,
        'created_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
