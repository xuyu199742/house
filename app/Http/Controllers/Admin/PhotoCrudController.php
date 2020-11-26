<?php

namespace App\Http\Controllers\Admin;

use App\Models\House;
use App\Models\Photo;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PhotoRequest as StoreRequest;
use App\Http\Requests\PhotoRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class PhotoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PhotoCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $house_id = request()->route('house_id');
        $this->data['house'] = $house = House::findOrFail($house_id);
        $this->data['house_id'] = $house_id;

        $this->crud->setModel('App\Models\Photo');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/house/'.$house_id.'/photo');
        $this->crud->setEntityNameStrings('图片', $house->name.'图片');

        $this->crud->addClause('ofHouse', $house_id);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'url',
                'label' => '图片',
                'type' => 'image'
            ],
            [
                'name' => 'desc',
                'label' => '描述'
            ],
            [
                'name' => 'category',
                'label' => '分类',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'url',
                'label' => '图片',
                'type' => 'browse'
            ],
            [
                'name' => 'desc',
                'label' => '描述'
            ],
            [
                'name' => 'category',
                'label' => '分类',
                'type' => 'select_from_array',
                'options' => Photo::CATEGORIES,
            ],
        ]);

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->setListView('house.photos');

        $this->crud->orderBy('order', 'desc');

        $this->crud->addFilter([
            'name' => 'category',
            'type' => 'dropdown',
            'label'=> '分类'
        ], Photo::CATEGORIES, function ($value) {
            $this->crud->addClause('where', 'category', $value);
        });
    }

    public function store(StoreRequest $request)
    {
        $request->merge(['house_id' => $this->data['house_id']]);
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
