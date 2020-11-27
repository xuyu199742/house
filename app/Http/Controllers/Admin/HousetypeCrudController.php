<?php

namespace App\Http\Controllers\Admin;

use App\Models\House;
use App\Models\Housetype;
use App\Models\Photo;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\HousetypeRequest as StoreRequest;
use App\Http\Requests\HousetypeRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class HousetypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class HousetypeCrudController extends CrudController
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
        $this->crud->setModel('App\Models\Housetype');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/house/'.$house_id.'/housetype');
        $this->crud->setEntityNameStrings('户型', $house->name.'户型');

        $this->crud->addClause('ofHouse', $house_id);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'photos',
                'label' => '图片',
                'type' => 'images'
            ],
            [
                'name' => 'title',
                'label' => '户型'
            ],
            [
                'name' => 'area',
                'label' => '面积'
            ],
            [
                'name' => 'livingroom_count',
                'label' => '客厅'
            ],
            [
                'name' => 'bedroom_count',
                'label' => '卧室'
            ],
            [
                'name' => 'kitchen_count',
                'label' => '厨房'
            ],
            [
                'name' => 'bathroom_count',
                'label' => '卫生间'
            ],
            [
                'name' => 'balcony_count',
                'label' => '阳台'
            ],
            [
                'name' => 'price',
                'label' => '价格',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'title',
                'label' => '户型'
            ],
            [
                'name' => 'desc',
                'label' => '户型解读'
            ],
//            [
//                'name' => 'sale_status',
//                'label' => '销售状态',
//                'type' => 'select_from_array',
//                'options' => Housetype::SALE_STATUS
//            ],
            [
                'name' => 'photos',
                'label' => '图片',
                'type' => 'browse_multiple',
                'mime_types' => ['image']
            ],
            [
                'name' => 'area',
                'label' => '面积'
            ],
            [
                'name' => 'bedroom_count',
                'label' => '卧室',
            ],
            [
                'name' => 'kitchen_count',
                'label' => '厨房',
            ],
            [
                'name' => 'livingroom_count',
                'label' => '客厅',
            ],
            [
                'name' => 'bathroom_count',
                'label' => '卫生间',
            ],
            [
                'name' => 'balcony_count',
                'label' => '阳台'
            ],
            [
                'name' => 'price',
                'label' => '价格',
            ],
            [
                'name' => 'price_type',
                'label' => '价格类型',
                'type' => 'select_from_array',
                'options' => Housetype::PRICE_TYPE
            ]
        ]);

        // add asterisk for fields that are required in PhotoRequest
        $this->crud->setRequiredFields(\App\Http\Requests\HousetypeRequest::class, 'create');
        $this->crud->setRequiredFields(\App\Http\Requests\HousetypeRequest::class, 'edit');
        $this->crud->setListView('house.housetype');
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
