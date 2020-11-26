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
class ShortcutCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Shortcut');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/shortcut');
        $this->crud->setEntityNameStrings('快捷入口', '快捷入口');

        $this->crud->orderBy('order', 'desc');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name'  => 'photo',
                'label' => '图片',
                'type'  => 'image'
            ],
            [
                'name'  => 'desc',
                'label' => '名称'
            ],
            [
                'name'  => 'link_data',
                'label' => '链接参数',
            ],
            [
                'name'  => 'start',
                'label' => '生效时间',
                'type'  => 'datetime',
            ],
            [
                'name'  => 'end',
                'label' => '失效时间',
                'type'  => 'datetime',
            ],
            [
                'name'  => 'desc',
                'label' => '备注'
            ],
            [
                'name'  => 'order',
                'label' => '排序',
            ],
        ]);


        $this->crud->addFields([
            [
                'name'  => 'photo',
                'label' => '图片',
                'type'  => 'browse'
            ],
            [
                'name'  => 'desc',
                'label' => '名称'
            ],
            [
                'name'  => 'link_data',
                'label' => '链接参数',
                'hint'  => '网页URL或小程序路径',
                'type'  => 'link_data'
            ],
            [
                'name'                    => 'start',
                'label'                   => '生效时间',
                'type'                    => 'datetime_picker',
                'hint'                    => '不填表示立即生效',
                'datetime_picker_options' => [
                    'language'        => "zh-cn",
                    'showClear'       => true,
                    'format'          => 'YYYY-MM-DD HH:mm:ss',
                    'showTodayButton' => true,
                ],
                'wrapperAttributes'       => [
                    'class' => 'col-md-6 form-group'
                ]
            ],
            [
                'name'                    => 'end',
                'label'                   => '失效时间',
                'type'                    => 'datetime_picker',
                'hint'                    => '不填表示一直生效',
                'datetime_picker_options' => [
                    'language'        => "zh-cn",
                    'format'          => 'YYYY-MM-DD HH:mm:ss',
                    'showClear'       => true,
                    'showTodayButton' => true,
                ],
                'wrapperAttributes'       => [
                    'class' => 'col-md-6 form-group'
                ]
            ],
            [
                'name'  => 'order',
                'label' => '排序',
                'hint'  => '数字越大越靠前',
                'type'  => 'number'
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
