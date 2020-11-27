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
class PropertiesCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Properties');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/properties');
        $this->crud->setEntityNameStrings('物业管理', '物业管理');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name'  => 'name',
                'label' => '名称',
                'type'  => 'house_title',
                'width' => '34px',
                'height' => '25px',
                'border-radius' => '3px',
            ],
            [
                'name' => 'fee',
                'label' => '物业费',
                'suffix' => '元/㎡•月',
            ],
            [
                'name' => 'address',
                'label' => '地址',
            ],
            [
                'name' => 'phone',
                'label' => '联系电话',
            ],
        ]);


        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => '名称',
            ],
            [
                'name'  => 'photo',
                'label' => '缩略图',
                'type'  => 'browse',
            ],
            [
                'name' => 'desc',
                'label' => '描述'
            ],
            [
                'name' => 'address',
                'label' => '地址',
            ],
            [
                'name' => 'fee',
                'label' => '物业费',
                'suffix' => '元/㎡•月',
            ],
            [
                'name' => 'phone',
                'label' => '联系电话',
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
