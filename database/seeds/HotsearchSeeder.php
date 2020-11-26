<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class HotsearchSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Hotsearch::create([
            'word' => '浦口',
        ]);

        \App\Models\Hotsearch::create([
            'word' => '荣耀府',
            'hot' => true,
            'link_data' => '/pages/house/show/index?id=1'
        ]);
    }
}
