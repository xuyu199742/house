<?php

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrs = [
            '建邺区' => [
                '南湖', '水西门', '湖西街'
            ],
            '鼓楼区' => [
                '龙江', '水佐岗', '三牌楼'
            ],
            '浦口区' => [
                '桥北', '大厂', '沿江'
            ],
        ];
        foreach ($arrs as $district => $blocks) {
            $dist = \App\Models\District::create([
                'name' => $district
            ]);

            foreach ($blocks as $block) {
                \App\Models\Block::create([
                    'name' => $block,
                    'district_id' => $dist->id
                ]);
            }
        }
    }
}
