<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class TagSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Tag::create([
            'name' => '地铁',
            'color' => '#d300f5'
        ]);
    }
}
