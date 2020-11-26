<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class TransactionSeeder extends Seeder {

    public function run()
    {
        for ($i = 1; $i < 60; $i ++)
        {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            \App\Models\Transaction::create([
                'date' => $date,
                'total_house' => rand(100, 1000),
                'total_area'  => rand(1000, 100000),
            ]);
        }
    }
}
