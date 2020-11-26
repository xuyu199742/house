<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blacklist;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\BlacklistRequest as StoreRequest;
use App\Http\Requests\BlacklistRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class BlacklistCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BlacklistCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Blacklist');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blacklist');
        $this->crud->setEntityNameStrings('黑名单', '黑名单');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'ban_type',
                'label' => '禁用类型',
                'type' => 'select_from_array',
                'options' => array_combine(Blacklist::TYPES, Blacklist::TYPES)
            ],
            [
                'name' => 'ban_data',
                'label' => '禁用内容',
            ],
            [
                'name' => 'memo',
                'label' => '备注',
            ],
            [
                'name' => 'created_at',
                'label' => '生效时间',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'ban_type',
                'label' => '禁用类型',
                'type' => 'select_from_array',
                'options' => array_combine(Blacklist::TYPES, Blacklist::TYPES)
            ],
            [
                'name' => 'ban_data',
                'label' => '禁用内容',
                'hint' => '用户 ID 或 IP 地址'
            ],
            [
                'name' => 'memo',
                'label' => '备注',
                'type' => 'textarea'
            ]
        ]);

        // add asterisk for fields that are required in BlacklistRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->addFilter([
            'name' => 'ban_type',
            'type' => 'dropdown',
            'label'=> '禁用类型'
        ], array_combine(Blacklist::TYPES, Blacklist::TYPES), function ($value) {
            $this->crud->addClause('where', 'ban_type', $value);
        });
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
