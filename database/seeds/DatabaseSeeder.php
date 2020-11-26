<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // required data
        $this->call(SettingsTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TabSeeder::class);
        $this->call(ShortcutSeeder::class);
        $this->call(HomeConfigCategorySeeder::class);
    }
}
