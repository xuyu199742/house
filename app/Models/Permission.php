<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Backpack\PermissionManager\app\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    const PERMISSION_HOUSE      = '楼盘管理';
    const PERMISSION_ARTICLE    = '资讯管理';
    const PERMISSION_COMMENT    = '评论管理';
    const PERMISSION_CONFIG     = '数据配置';
    const PERMISSION_SYSTEM     = '系统管理';
    const PERMISSION_DATA       = '交易数据';
    const PERMISSION_QUESTION   = '答疑管理';
    const PERMISSION_TRACKER    = '用户行为';

    protected $fillable = [ 'name', 'guard_name', 'updated_at', 'created_at', 'display_name' ];
}
