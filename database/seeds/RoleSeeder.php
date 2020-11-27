<?php

use Illuminate\Database\Seeder;

use \App\Models\Permission;
use \App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            '房源管理',
            '资讯管理',
            '评论管理',
            '数据配置',
            '系统管理',
            '交易数据',
            '答疑管理',
            '用户行为',
        ];

        $roles = [
            '管理员',
            '编辑'
        ];

        foreach ($permissions as $name) {
            Permission::create(compact('name'));
        }

        foreach ($roles as $name) {
            Role::create(compact('name'));
        }

        $admin_role = Role::find(1);
        $admin_role->permissions()->sync(Permission::all());

        $admin_user = \App\User::create([
            'email' => 'admin@demo.com',
            'password' => bcrypt('secret'),
            'name' => '系统管理员',
            'username' => 'admin',
            'is_admin' => true
        ]);

        $admin_user->assignRole('管理员');

    }
}
