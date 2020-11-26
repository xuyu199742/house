<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key'         => 'terms_and_condition',
                'name'        => '免责声明',
                'description' => '免责声明',
                'value'       => '<p>&nbsp; &nbsp; 本页面内容，旨在满足广大用户的信息需求而采集提供，如有异议请及时与我们联系。页面所载内容不代表本网站之观点或意见，仅供用户参考与借鉴，最终以政府网站或开发商实际公示为准。商品房预售须取得《商品房预售许可证》，用户在购房时需慎重查验开发商的证件信息。</p>',
                'field'       => '{"name":"value","label":"Value","type":"wysiwyg"}',
                'active'      => 1,
            ],
            [
                'key'         => 'default_avatar',
                'name'        => '默认头像',
                'description' => '默认用户头像',
                'value'       => 'images/avatar.png',
                'field'       => '{"name":"value","label":"Value","type":"browse"}',
                'active'      => 1,
            ],
            [
                'key'         => 'comment_audit',
                'name'        => '评论审核机制',
                'description' => '先发后审或者先审后发',
                'value'       => '0',
                'field'       => '{"name":"value","label":"先审后发","type":"checkbox", "hint":"选中表示先审后发, 不选表示先发后审"}',
                'active'      => 1,
            ],
            [
                'key'         => 'public_account',
                'name'        => '系统名称',
                'description' => '系统名称',
                'value'       => '楼市放大镜',
                'field'       => '{"name":"value","label":"系统名称","type":"text"}',
                'active'      => 1,
            ],
            [
                'key'         => 'public_account_image',
                'name'        => '公众号图片',
                'description' => '公众号图片',
                'value'       => 'images/qr.png?1',
                'field'       => '{"name":"value","label":"公众号图片","type":"browse"}',
                'active'      => 1,
            ],
            [
                'key'         => 'default_search',
                'name'        => '默认搜索词',
                'description' => '默认搜索词',
                'value'       => '浦口',
                'field'       => '{"name":"value","label":"默认搜索词","type":"text"}',
                'active'      => 1,
            ],
            [
                'key'         => 'wechat_account',
                'name'        => '微信号',
                'description' => '用于购房答疑中，让用户复制',
                'value'       => '楼市放大镜',
                'field'       => '{"name":"value","label":"微信号","type":"text"}',
                'active'      => 1,
            ],
        ];

        foreach ($settings as $index => $setting) {
            $result = DB::table('settings')->insert($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
        }

        $this->command->info('Inserted '.count($settings).' records.');
    }
}
