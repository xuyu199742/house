<?php

use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrs = [
            [
                'photo' => 'images/sponsor/start.jpg' . '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_START,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/4.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TOP,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/2.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TOP,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/3.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TOP,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/5.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TAPES,
                'sub_position' => 1,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/5.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TAPES,
                'sub_position' => 1,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/5.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TAPES,
                'sub_position' => 2,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/5.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TAPES,
                'sub_position' => 3,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/5.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TAPES,
                'sub_position' => 4,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/5.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_TAPES,
                'sub_position' => 5,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/4.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_SEARCH,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/1.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_SEARCH,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/2.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_ARTICLE,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/4.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_ARTICLE,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/1.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_QUESTION,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
            [
                'photo' => 'images/sponsor/2.jpg'. '?'.rand(10000, 99999),
                'position' => \App\Models\Sponsor::POSITION_QUESTION,
                'link_type' => 'app',
                'link_data' => '/pages/house/detail/index?id=1',
            ],
        ];
        foreach ($arrs as $item) {
            \App\Models\Sponsor::create($item);
        }
    }
}
