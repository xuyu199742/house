<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\CrudPanel;

/**
 * Class SystemLogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SystemLogCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\SystemLog');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/systemlog');
        $this->crud->setEntityNameStrings('访问日志', '访问日志');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name' => 'url',
                'label' => '访问路径'
            ],
            [
                'name' => 'method',
                'label' => '请求类型'
            ],
            [
                'name' => 'user_id',
                'label' => '用户id'
            ],
            [
                'name' => 'created_at',
                'label' => '时间'
            ]
        ]);

        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->allowAccess(['show']);
        $this->crud->orderBy('created_at', 'desc');

//        $this->crud->enableBulkActions();
//        $this->crud->addBulkDeleteButton();
//        $this->crud->addButtonFromView('top', 'truncate', 'truncate_systemlog');
    }
}
