<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ShortcutRequest as StoreRequest;
use App\Http\Requests\ShortcutRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ShortcutCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ResidentialCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Residential');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/residential');
        $this->crud->setEntityNameStrings('小区管理', '小区管理');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => '小区编号',
            ],
            [
                'name' => 'name',
                'label' => '小区名称',
                'type'  => 'house_title',
                'width' => '34px',
                'height' => '25px',
                'border-radius' => '3px',
            ],
            [
                'name' => 'alias',
                'label' => '小区别名',
            ],
            [
                'name' => 'type',
                'label' => '建筑类型',
            ],
            [
                'name' => 'architectural_age',
                'label' => '建筑年代',
            ],
        ]);


        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => '小区名称',
            ],
            [
                'name' => 'photo',
                'label' => '缩略图',
                'type' => 'browse',
            ],
            [
                'name' => 'alias',
                'label' => '小区别名',
            ],
            [
                'name' => 'type',
                'label' => '建筑类型',
            ],
            [
                'name' => 'architectural_age',
                'label' => '建筑年代',
            ],

            [
                'name' => 'building_count',
                'label' => '楼栋总数',
            ],
            [
                'name' => 'house_count',
                'label' => '房屋总数',
            ],
            [
                'name' => 'parking',
                'label' => '车位数',
            ],
            [
                'name' => 'park_money',
                'label' => '停车费',
            ],
            [
                'name' => 'park_proportion',
                'label' => '车位比例',
            ],
            [
                'label' => "物业公司",
                'type' => 'select2',
                'name' => 'properties_id',
                'entity' => 'properties',
                'attribute' => 'name',
                'model' => "App\Models\Properties",
            ],
            [
                'name' => 'property_address',
                'label' => '物业地址',
            ],
            [
                'name' => 'property_phone',
                'label' => '物业电话',
            ],
            [
                'name' => 'developer',
                'label' => '开发商',
            ],
            [
                'name' => 'desc',
                'label' => '描述',
                'type' => 'textarea',
            ],

        ]);

        // add asterisk for fields that are required in ShortcutRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
