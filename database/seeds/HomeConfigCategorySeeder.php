<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class HomeConfigCategorySeeder extends Seeder {

    public function run()
    {
        $categories = [
            '热门楼盘',
            '最新楼盘',
            '即将预售',
            '最新摇号',
            '摇号剩余',
        ];

        foreach ($categories as $category)
        {
            $model = \App\Models\HomeconfigCategory::create([
                'name' => $category
            ]);
        }

    }
}
