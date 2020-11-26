<?php

use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder {

    public function run()
    {

        $properties = [
            '住宅',
            '公寓',
            '商住',
            '写字楼',
            '其他'
        ];

        foreach ($properties as $property)
        {
            \App\Models\PropertyType::create([
                'key'  => $property,
                'name' => $property
            ]);
        }

        $houses = [
            '荣耀府',
            '仙林首望城',
            '弘阳燕澜七缙',
            '碧桂园湖光山色',
            '路易庄园',
            '金浦紫御东方',
            '长发都市诸公',
            '绿国万象都荟',
            '卧龙湖小镇',
            '花样年喜年中心',
            '荣盛鹭岛荣府',
            '涟城二期',
            '山河水花园',
            '卧龙湖小镇',
            '明发阅山悦府',
            '融侨观邸二期',
            '蓝光黑钻公馆',
            '浦泰和天下三期',
            '万宇汽车五金博览中心',
        ];

        foreach ($houses as $index => $house)
        {
            $price  = rand(100, 600);
            $prefix = rand(1, 2) == 1 ? '约' : '惠后';
            $house  = \App\Models\House::create([
                'name'                => $house,
                'status'              => \App\Models\House::STATUS_PUBLISH,
                'property_type'       => '住宅',
                'block_id'            => rand(1, 9),
                'price'               => $price,
                'display_price'       => $prefix . ' ' . ( rand(1, 3) > 1 ? number_format($price * 100) . '/㎡' : $price . '万/套' ),
                'open_at'             => '2018-11-10',
                'sale_status'         => '在售',
                'developer'           => '南京平弘房地产开发有限公司',
                'property_management' => '南京弘阳物业管理有限公司',
                'number_of_year'      => '70',
                'area'                => rand(1000, 99999),
                'address'             => '江北大道与新沿路交汇处',
                'photo'               => "images/house/{$index}.jpg",
                'sales_phone'         => rand(1000000, 2000000),
                'latitude'            => '32.048204499596',
                'total_view'          => rand(10, 100000),
                'total_favor'         => rand(10, 10000),
                'price_from'          => rand(1, 3)*10000,
                'price_to'            => rand(3, 6)*10000,
                'amount_from'         => rand(30, 50),
                'amount_to'           => rand(50, 400),
                'category_1'          => rand(0, 1),
                'category_2'          => rand(0, 1),
                'category_3'          => rand(0, 1),
                'category_4'          => rand(0, 1),
                'category_5'          => rand(0, 1),
                'longitude'           => '118.79924871429',
                'around_shop'         => '南京旭日东升眼镜(八百店)、苏润超市(八百桥青龙农贸市场店)、辉煌酒业(招贤西路店)、钓友渔具店(金和路)、天天鲜果吧、母婴坊(金牛湖旗舰店)、苏购超市(青龙西街)、立新烟酒(八龙线)',
                'around_bank'         => '好又多购物中心、苏果超市(招贤东路店)、南京旭日东升眼镜(八百店)、苏润超市(八百桥青龙农贸市场店)、辉煌酒业(招贤西路店)、钓友渔具店(金和路)、天天鲜果吧、母婴坊(金牛湖旗舰店)、苏购超市(青龙西街)、立新烟酒(八龙线)',
                'around_hospital'     => '金牛湖医院、金牛湖街道畜牧兽医站、聚传正骨堂膏药铺八百桥店',
                'around_park'         => '苏果超市(招贤东路店)、南京旭日东升眼镜(八百店)、苏润超市(八百桥青龙农贸市场店)、辉煌酒业(招贤西路店)、钓友渔具店(金和路)、天天鲜果吧、母婴坊(金牛湖旗舰店)、苏购超市(青龙西街)、立新烟酒(八龙线)',
                'around_traffic'      => '苏润超市(八百桥青龙农贸市场店)、辉煌酒业(招贤西路店)、钓友渔具店(金和路)、天天鲜果吧、母婴坊(金牛湖旗舰店)、苏购超市(青龙西街)、立新烟酒(八龙线)',
                'around_school'       => '金牛湖中心小学、金牛湖初级中学、金牛湖中心幼儿园、新城幼儿园、修而远教育、学尚教育、励优教育、博杰思教育、春蕾教育、乐学教育(青龙街)',
                'desc'                => '荣耀府位于六合区金牛湖街道茉莉花路77号，在售楼栋1-13栋的叠加别墅和高层，叠墅的均价为14083元/m²，高层的均价为10500元/m²，交付标准是毛坯。项目现有地铁是S8号线八百桥站，无缝对接3号线，畅达全城。周边生活配套齐全，吃喝玩乐购一应俱全；还有国家4A级的金牛湖度假区就在项目的旁边。'
            ]);
            $house->property_types()->attach(rand(1, 5));
            $house->informations()->saveMany(factory(\App\Models\Information::class, rand(12, 30))->make());
            $house->comments()->saveMany(factory(\App\Models\Comment::class, rand(5, 20))->make());
            $house->photos()->saveMany(factory(\App\Models\Photo::class, rand(30, 50))->make());
            $house->housetypes()->saveMany(factory(\App\Models\Housetype::class, rand(3, 8))->make());
        }

    }
}
