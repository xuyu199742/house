<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tracker;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TrackerRequest as StoreRequest;
use App\Http\Requests\TrackerRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class TrackerCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TrackerCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Tracker');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tracker');
        $this->crud->setEntityNameStrings('用户行为', '用户行为');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name'    => 'page',
                'label'   => '页面 ID',
            ],
            [
                'name'    => 'action',
                'label'   => '事件 ID',
            ],
            [
                'name'    => 'data',
                'label'   => '事件参数',
            ],
            [
                'name'    => 'user_id',
                'label'   => '用户ID',
            ],
            [
                'name'    => 'ip',
                'label'   => 'IP 地址',
            ],
            [
                'name'    => 'platform',
                'label'   => '平台信息',
            ],
            [
                'name'    => 'created_at',
                'label'   => '时间',
            ]
        ]);

        $this->crud->removeAllButtons();

        $this->crud->addFilter([
            'name' => 'page',
            'type' => 'text',
            'label'=> '页面ID'
        ], '', function ($value) {
            $this->crud->addClause('where', 'page', $value);
        });

        $this->crud->addFilter([
            'name' => 'action',
            'type' => 'text',
            'label'=> '事件ID'
        ], '', function ($value) {
            $this->crud->addClause('where', 'action', $value);
        });

        $this->crud->addFilter([
            'name' => 'data',
            'type' => 'text',
            'label'=> '事件参数'
        ], '', function ($value) {
            $this->crud->addClause('where', 'data', 'like', "%{$value}%");
        });

        $this->crud->addFilter([
            'name' => 'user_id',
            'type' => 'text',
            'label'=> '用户ID'
        ], '', function ($value) {
            $this->crud->addClause('where', 'user_id', $value);
        });

        $this->crud->addFilter([
            'name' => 'ip',
            'type' => 'text',
            'label'=> 'IP 地址'
        ], '', function ($value) {
            $this->crud->addClause('where', 'ip', $value);
        });

        $this->crud->addFilter([
            'name' => 'platform',
            'type' => 'text',
            'label'=> '平台信息'
        ], '', function ($value) {
            $this->crud->addClause('where', 'platform', 'like', '%'.$value.'%');
        });

        $this->crud->addFilter([
            'name' => 'created_at',
            'type' => 'date_range',
            'label'=> '时间'
        ], '', function ($value) {
            $dates = json_decode($value);
            $this->crud->addClause('where', 'created_at', '>=', $dates->from. ' 00:00:00');
            $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
        });
        $this->crud->orderBy('created_at', 'desc');
        // add asterisk for fields that are required in TrackerRequest
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
