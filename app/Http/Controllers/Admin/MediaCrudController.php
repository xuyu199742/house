<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MediaRequest as StoreRequest;
use App\Http\Requests\MediaRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class MediaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MediaCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Media');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/media');
        $this->crud->setEntityNameStrings('来源平台', '来源平台');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'avatar',
                'label' => '头像',
                'type' => 'image'
            ],
            [
                'name' => 'name',
                'label' => '名称'
            ],
            [
                'name' => 'memo',
                'label' => '备注'
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => '名称'
            ],
            [
                'name' => 'avatar',
                'label' => '头像',
                'type' => 'browse'
            ],
            [
                'name' => 'memo',
                'label' => '备注'
            ],
        ]);

        // add asterisk for fields that are required in MediaRequest
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
