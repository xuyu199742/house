<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\BlockRequest as StoreRequest;
use App\Http\Requests\BlockRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class BlockCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BlockCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */

        $district_id = request()->route('district_id');
        $this->data['district'] = $district = District::findOrFail($district_id);
        $this->data['district_id'] = $district_id;
        $this->crud->setModel('App\Models\Block');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/district/'.$district_id.'/block');
        $this->crud->setEntityNameStrings('板块', $district->name.'板块');

        $this->crud->addClause('ofDistrict', $district_id);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumn([
            'name' => 'name',
            'label' => '名称'
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => '名称'
        ]);


        // add asterisk for fields that are required in BlockRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $this->updateDistrict($request);
        $redirect_location = parent::storeCrud($request);
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $this->updateDistrict($request);
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }

    public function updateDistrict($request)
    {
        $request->merge(['district_id'=>$this->data['district_id']]);
    }
}
