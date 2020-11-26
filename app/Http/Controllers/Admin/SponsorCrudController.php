<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeconfigCategory;
use App\Models\House;
use App\Models\Sponsor;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SponsorRequest as StoreRequest;
use App\Http\Requests\SponsorRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Carbon\Carbon;

/**
 * Class SponsorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SponsorCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Sponsor');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sponsor');
        $this->crud->setEntityNameStrings('广告', '广告');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name' => 'photo',
                'label' => '图片',
                'type' => 'image'
            ],
            [
                'name' => 'intime',
                'label' => '状态',
                'type' => 'intime'
            ],
            [
                'name' => 'position',
                'label' => '位置',
                'type' => 'select_from_array',
                'options' => Sponsor::POSITIONS,
            ],
            [
                'name' => 'sub_position',
                'label' => '腰封位置',
                'hint' => '位置为首页腰封时选择',
                'type' => 'select_from_array',
                'options' => HomeconfigCategory::pluck('name', 'id')->toArray(),
            ],
            [
                'name' => 'link_data',
                'label' => '链接参数',
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
            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'position',
                'label' => '位置',
                'type' => 'select_from_array',
                'options' => Sponsor::POSITIONS,
                'wrapperAttributes' => [
                    'class' => 'col-md-3 form-group'
                ]
            ],
            [
                'name' => 'sub_position',
                'label' => '腰封位置',
                'type' => 'select_from_array',
                'options' => HomeconfigCategory::pluck('name', 'id')->toArray(),
                'wrapperAttributes' => [
                    'class' => 'col-md-3 form-group'
                ]
            ],
            [
                'name' => 'title',
                'label' => '标题',
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ]
            ],
            [
                'name' => 'photo',
                'label' => '图片',
                'type' => 'browse'
            ],
            [
                'name' => 'link_data',
                'label' => '链接参数',
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
                'name' => 'order',
                'label' => '排序',
                'hint' => '数字越大越靠前',
                'type' => 'number'
            ],
        ]);
        $this->crud->allowAccess('list');
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->addFilter([
            'name' => 'intime',
            'type' => 'dropdown',
            'label'=> '状态'
        ], [
            'not_start' => '未开始',
            'ended' => '结束',
            'active' => '生效'
        ], function ($value) {
            switch ($value) {
                case 'not_start':
                    $this->crud->addClause('where', 'start', '>', Carbon::now());
                    break;
                case 'ended':
                    $this->crud->addClause('where', 'end', '<', Carbon::now());
                    break;
                default:
                    $this->crud->addClause('intime');
                    break;
            }
        });

        $this->crud->addFilter([
            'name' => 'position',
            'type' => 'dropdown',
            'label'=> '位置'
        ], Sponsor::POSITIONS, function ($value) {
            $this->crud->addClause('where', 'position', $value);
        });

        $this->crud->addField([
            'name' => 'hide_sub_position',
            'type' => 'hide_sub_position'
        ]);
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
