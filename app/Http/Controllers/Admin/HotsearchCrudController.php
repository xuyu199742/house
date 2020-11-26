<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hotsearch;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\HotsearchRequest as StoreRequest;
use App\Http\Requests\HotsearchRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class HotsearchCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class HotsearchCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Hotsearch');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/hotsearch');
        $this->crud->setEntityNameStrings('热搜词', '热搜词');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name'  => 'word',
                'label' => '热词'
            ],
            [
                'name' => 'intime',
                'label' => '状态',
                'type' => 'intime'
            ],
            [
                'name'  => 'hot',
                'label' => '高亮显示',
                'type'  => 'check'
            ],
            [
                'name'  => 'link_data',
                'label' => '跳转链接'
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
        ]);

        $this->crud->addFields([
            [
                'name'  => 'word',
                'label' => '热词'
            ],
            [
                'name'  => 'hot',
                'label' => '高亮显示',
                'type'  => 'checkbox'
            ],
            [
                'name'  => 'link_data',
                'label' => '跳转链接',
                'type' => 'link_data'
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
                'name'  => 'order',
                'label' => '排序',
                'type'  => 'number'
            ],
        ]);

        $this->crud->orderBy('order', 'desc');
        // add asterisk for fields that are required in HotsearchRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->addFilter(
            [
                'type'  => 'simple',
                'name'  => 'hot',
                'label' => '重点推荐'
            ],
            false,
            function () {
                $this->crud->addClause('where', 'hot', true);
            }
        );
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
