<?php

use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // optional data
        $this->call(DistrictSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(HouseSeeder::class);
        $this->call(SponsorSeeder::class);
        $this->call(ContentSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(HomeConfigSeeder::class);
        $this->call(HotsearchSeeder::class);
    }
}
