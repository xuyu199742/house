<?php

use Illuminate\Database\Seeder;

class ShortcutSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrs = [
            [
                'photo' => 'images/shortcut/new/1.png?' . rand(10000, 99999),
                'link_data' => '/pages/house/list/index?type=1',
                'desc'      => '热门房源'
            ],
            [
                'photo' => 'images/shortcut/new/2.png?' . rand(10000, 99999),
                'link_data' => '/pages/house/list/index?type=2',
                'desc'      => '最新房源'
            ],
            [
                'photo' => 'images/shortcut/new/3.png?' . rand(10000, 99999),
                'link_data' => '/pages/house/list/index?type=3',
                'desc'      => '即将预售'
            ],
            [
                'photo' => 'images/shortcut/new/4.png?' . rand(10000, 99999),
                'link_data' => '/pages/house/list/index?type=4',
                'desc'      => '最新摇号'
            ],
            [
                'photo' => 'images/shortcut/new/5.png?' . rand(10000, 99999),
                'link_data' => '/pages/house/list/index?type=5',
                'desc'      => '摇号剩余'
            ],
            [
                'photo' => 'images/shortcut/new/6.png?' . rand(10000, 99999),
                'link_data' => 'http://www.sohu.com/a/294613449_124714',
                'desc'      => '资格查询'
            ],
            [
                'photo' => 'images/shortcut/new/7.png?' . rand(10000, 99999),
                'link_data' => '/pages/house/list/index',
                'desc'      => '全部房源'
            ],
            [
                'photo' => 'images/shortcut/new/8.png?' . rand(10000, 99999),
                'link_data' => '/pages/transaction/index',
                'desc'      => '交易数据'
            ],
            [
                'photo' => 'images/shortcut/new/9.png?' . rand(10000, 99999),
                'link_data' => '/pages/calculator/index/index',
                'desc'      => '房贷计算'
            ],
            [
                'photo' => 'images/shortcut/new/10.png?' . rand(10000, 99999),
                'link_data' => '/pages/article/index',
                'desc'      => '楼市新闻'
            ],
        ];
        foreach ($arrs as $item)
        {
            \App\Models\Shortcut::create($item);
        }
    }
}
