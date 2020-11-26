<?php

use Illuminate\Database\Seeder;

class TabSeeder extends Seeder
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
                'photo' => 'images/tab/index.png',
                'photo_selected' => 'images/tab/index_active.png',
                'name' => '首页',
                'link_data' => '/pages/house/home/index'
            ],
            [
                'photo' => 'images/tab/circle.png',
                'photo_selected' => 'images/tab/circle_active.png',
                'name' => '房友圈',
                'link_data' => '/pages/article/index'
            ],
            [
                'photo' => 'images/tab/question.png',
                'photo_selected' => 'images/tab/question_active.png',
                'name' => '答疑',
                'link_data' => '/pages/question/index'
            ],
            [
                'photo' => 'images/tab/me.png',
                'photo_selected' => 'images/tab/me_active.png',
                'name' => '我的',
                'link_data' => '/pages/account/index'
            ],
        ];
        foreach ($arrs as $item) {
            \App\Models\Tab::create($item);
        }
    }
}
