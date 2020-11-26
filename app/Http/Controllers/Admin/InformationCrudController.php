<?php

namespace App\Http\Controllers\Admin;

use App\Models\House;
use App\Models\Information;
use App\Models\Media;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\InformationRequest as StoreRequest;
use App\Http\Requests\InformationRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class InformationCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class InformationCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $house_id                 = request()->route('house_id');
        $this->data[ 'house' ]    = $house = House::findOrFail($house_id);
        $this->data[ 'house_id' ] = $house_id;

        $this->crud->setModel('App\Models\Information');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/house/' . $house_id . '/information');

        $this->crud->setEntityNameStrings('动态', '动态');

        $this->crud->addClause('ofHouse', $house_id);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name'  => 'title',
                'label' => '标题'
            ],
            [
                'name'              => 'type',
                'label'             => '类型',
                'type'              => 'select_from_array',
                'options'           => array_combine(Information::TYPES, Information::TYPES),
                'wrapperAttributes' => [
                    'class' => 'col-md-2 form-group'
                ]
            ],
            [
                'name'  => 'avatar',
                'label' => '媒体头像',
                'type'  => 'image'
            ],
            [
                'name'  => 'author',
                'label' => '媒体名称'
            ],
            [
                'name'  => 'created_at',
                'label' => '创建时间'
            ],
            [
                'name'  => 'updated_at',
                'label' => '更新时间'
            ],
        ]);

        $this->crud->addFields([
            [
                'name'              => 'type',
                'label'             => '类型',
                'type'              => 'select_from_array',
                'options'           => array_combine(Information::TYPES, Information::TYPES),
                'wrapperAttributes' => [
                    'class' => 'col-md-2 form-group'
                ],
                'tab' => '动态内容'
            ],
            [
                'name'              => 'title',
                'label'             => '标题',
                'wrapperAttributes' => [
                    'class' => 'col-md-10 form-group'
                ],
                'tab' => '动态内容'
            ],
            [
                'name' => 'media_id',
                'label' => '来源平台',
                'type' => 'select',
                'entity' => 'media',
                'model' => Media::class,
                'attribute' => 'name',
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ]
            ],
            [
                'name'  => 'content',
                'label' => '正文',
                'type'  => 'textarea',
                'tab' => '动态内容'
            ],
        ]);

        if ($this->crud->actionIs('create')) {
            $this->crud->addFields([
                [
                    'name'  => 'content',
                    'label' => '正文',
                    'type'  => 'textarea',
                    'tab' => '动态内容'
                ],
                [
                    'name'  => 'notify',
                    'label' => '发送通知给订阅用户',
                    'type'  => 'checkbox',
                    'tab' => '消息通知'
                ],
                [
                    'name'  => 'message_title',
                    'label' => '通知标题（不填则使用动态标题）',
                    'tab' => '消息通知'
                ],
                [
                    'name'  => 'message_content',
                    'label' => '通知内容（不填则使用动态内容）',
                    'type'  => 'textarea',
                    'tab' => '消息通知'
                ]
            ]);
        }

        $this->crud->setListView('house.information');

        $this->crud->addFilter([
            'name'  => 'type',
            'type'  => 'dropdown',
            'label' => '动态类型'
        ], array_combine(Information::TYPES, Information::TYPES), function ($value) {
            $this->crud->addClause('where', 'type', $value);
        });

        // add asterisk for fields that are required in InformationRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $request->merge([ 'house_id' => $this->data[ 'house_id' ] ]);

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
