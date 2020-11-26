<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SubwayRequest as StoreRequest;
use App\Http\Requests\SubwayRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class SubwayCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubwayCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Subway');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subway');
        $this->crud->setEntityNameStrings('地铁线路', '地铁线路');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name'  => 'name',
                'label' => '名称'
            ],
            [
                'name'    => 'status',
                'label'   => '状态',
                'type'    => 'select_from_array',
                'options' => [
                    '1' => '已通车',
                    '2' => '在建',
                    '3' => '规划中'
                ]
            ]
        ]);
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => '名称'
            ],
            [
                'name'    => 'status',
                'label'   => '状态',
                'type'    => 'select_from_array',
                'options' => [
                    '1' => '已通车',
                    '2' => '在建',
                    '3' => '规划中'
                ]
            ]
        ]);

        $this->crud->addButtonFromView('line', 'stations', 'stations');

        // add asterisk for fields that are required in SubwayRequest
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
