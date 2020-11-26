<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subway;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StationRequest as StoreRequest;
use App\Http\Requests\StationRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class StationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StationCrudController extends CrudController
{
    public function setup()
    {
        $subway_id = request()->route('subway_id');
        $this->data['subway'] = $subway = Subway::findOrFail($subway_id);
        $this->data['subway_id'] = $subway_id;

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Station');
        $this->crud->setRoute(config('backpack.base.route_prefix') . "/subway/{$subway_id}/station");
        $this->crud->setEntityNameStrings('站点', $subway->name.'站点');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => '站点名称',
            ],
            [
                'name' => 'status',
                'label' => '状态',
                'type' => 'select_from_array',
                'options' => [
                    '1' => '已通车',
                    '2' => '在建',
                    '3' => '规划中'
                ]
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'subway_id',
                'label' => '地铁线',
                'type' => 'hidden',
                'value' => $subway_id
            ],
            [
                'name' => 'name',
                'label' => '站点名称',
            ],
            [
                'name' => 'status',
                'label' => '状态',
                'type' => 'select_from_array',
                'options' => [
                    '1' => '已通车',
                    '2' => '在建',
                    '3' => '规划中'
                ]
            ],
            [
                'name' => 'longitude',
                'label' => '经度',
            ],
            [
                'name' => 'latitude',
                'label' => '维度',
            ],
            [
                'name' => 'address',
                'label' => '经度',
                'type' => 'map',
            ],
        ]);

        $this->crud->addClause('ofSubway', $subway_id);

        $this->crud->addButtonFromView('top', 'subway', 'subway', 'beginning');

        // add asterisk for fields that are required in StationRequest
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
