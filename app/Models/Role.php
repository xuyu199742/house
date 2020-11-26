<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Backpack\PermissionManager\app\Models\Role as BaseRole;

class Role extends BaseRole
{
    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at', 'display_name'];
}
