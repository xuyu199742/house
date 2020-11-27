<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class HomeConfigCategorySeeder extends Seeder {

    public function run()
    {
        $categories = [
            '热门房源',
            '最新房源',
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
