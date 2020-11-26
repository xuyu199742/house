<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sensitive;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SensitiveRequest as StoreRequest;
use App\Http\Requests\SensitiveRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class SensitiveCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SensitiveCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Sensitive');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sensitive');
        $this->crud->setEntityNameStrings('禁发词', '禁发词');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'word',
                'label' => '禁发词',
            ],
            [
                'name' => 'handle',
                'label' => '处理方式',
                'type' => 'select_from_array',
                'options' => array_combine(Sensitive::HANDLES, Sensitive::HANDLES)
            ],
            [
                'name' => 'ban_user',
                'label' => '封用户',
                'type' => 'check',
            ],
            [
                'name' => 'ban_ip',
                'label' => '封 IP',
                'type' => 'check',
            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'word',
                'label' => '禁发词',
            ],
            [
                'name' => 'handle',
                'label' => '处理方式',
                'type' => 'select_from_array',
                'options' => array_combine(Sensitive::HANDLES, Sensitive::HANDLES)
            ],
            [
                'name' => 'ban_user',
                'label' => '封用户',
                'type' => 'checkbox',
                'wrapperAttributes' => [
                    'class' => 'col-md-3 form-group'
                ]
            ],
            [
                'name' => 'ban_ip',
                'label' => '封 IP',
                'type' => 'checkbox',
                'wrapperAttributes' => [
                    'class' => 'col-md-3 form-group'
                ]
            ]
        ]);

        // add asterisk for fields that are required in SensitiveRequest
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
