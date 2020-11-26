<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tab;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TabRequest as StoreRequest;
use App\Http\Requests\TabRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class TabCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TabCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Tab');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tab');
        $this->crud->setEntityNameStrings('底部导航', '底部导航');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => '标题'
            ],
            [
                'name' => 'photo',
                'label' => '图片',
                'type' => 'image',
            ],
            [
                'name' => 'id',
                'label' => '状态',
                'type' => 'intime',
            ],
            [
                'name' => 'photo_selected',
                'label' => '选中时图片',
                'type' => 'image',
            ],
            [
                'name' => 'link_data',
                'label' => '链接页面',
                'type' => 'select_from_array',
                'options' => Tab::LINK_DATAS,
            ],
            [
                'name' => 'start',
                'label' => '生效时间',
                'type' => 'datetime',
            ],
            [
                'name' => 'end',
                'label' => '失效时间',
                'type' => 'datetime',
            ],
            [
                'name' => 'order',
                'label' => '排序',
                'hint' => '数字越大越靠前',
                'type' => 'number'
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => '标题',
                'wrapperAttributes' => [
                    'class' => 'col-md-10 form-group'
                ]
            ],
            [
                'name' => 'link_data',
                'label' => '链接页面',
                'type' => 'select_from_array',
                'options' => Tab::LINK_DATAS,
                'wrapperAttributes' => [
                    'class' => 'col-md-2 form-group'
                ]
            ],
            [
                'name' => 'photo',
                'label' => '图片',
                'type' => 'browse',
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ]
            ],
            [
                'name' => 'photo_selected',
                'label' => '选中时图片',
                'type' => 'browse',
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ]
            ],

            [
                'name' => 'start',
                'label' => '生效时间',
                'type' => 'datetime_picker',
                'hint' => '不填表示立即生效',
                'datetime_picker_options' => [
                    'language' => "zh-cn",
                    'showClear' => true,
                    'format' => 'YYYY-MM-DD HH:mm:ss',
                    'showTodayButton' => true,
                ],
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ]
            ],
            [
                'name' => 'end',
                'label' => '失效时间',
                'type' => 'datetime_picker',
                'hint' => '不填表示一直生效',
                'datetime_picker_options' => [
                    'language' => "zh-cn",
                    'format' => 'YYYY-MM-DD HH:mm:ss',
                    'showClear' => true,
                    'showTodayButton' => true,
                ],
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ]
            ],
            [
                'name' => 'order',
                'label' => '排序',
                'hint' => '数字越大越靠前',
                'type' => 'number'
            ],
        ]);

        $this->crud->orderBy('order', 'desc');

        // add asterisk for fields that are required in TabRequest
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
