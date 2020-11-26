<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TransactionRequest as StoreRequest;
use App\Http\Requests\TransactionRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TransactionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Transaction');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/transaction');
        $this->crud->setEntityNameStrings('交易数据', '交易数据');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'date',
                'label' => '日期',
            ],
            [
                'name' => 'total_house',
                'label' => '成交套数',
            ],
            [
                'name' => 'total_area',
                'label' => '成交面积'
            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'date',
                'label' => '日期',
                'type' => 'date_picker'
            ],
            [
                'name' => 'total_house',
                'label' => '成交套数',
                'suffix' => '套',
            ],
            [
                'name' => 'total_area',
                'label' => '成交面积',
                'suffix' => '平方米'
            ]
        ]);

        $this->crud->orderBy('date', 'desc');

        // add asterisk for fields that are required in TransactionRequest
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
