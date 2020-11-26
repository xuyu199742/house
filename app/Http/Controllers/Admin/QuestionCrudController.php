<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\QuestionRequest as StoreRequest;
use App\Http\Requests\QuestionRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class QuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class QuestionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Question');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/question');
        $this->crud->setEntityNameStrings('提问', '提问');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'content',
                'label' => '问题',
            ],
            [
                'name' => 'hot',
                'label' => '热门',
                'type' => 'check'
            ],
            [
                'name' => 'user_id',
                'label' => '提问用户',
                'type' => 'user'
            ],
            [
                'name' => 'answered',
                'label' => '已回答',
                'type' => 'check'
            ],
            [
                'name' => 'view_count',
                'label' => '浏览人数',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'content',
                'label' => '问题',
                'type' => 'textarea'
            ],
            [
                'name' => 'hot',
                'label' => '热门',
                'type' => 'checkbox'
            ],
            [
                'name' => 'answer',
                'label' => '回答内容',
                'type' => 'textarea'
            ]
        ]);

        // add asterisk for fields that are required in QuestionRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('created_at', 'desc');

        $this->crud->addFilter(
            [ // simple filter
            'type' => 'simple',
            'name' => 'not_answered',
            'label'=> '未回答'
        ],
        false,
        function () {
            $this->crud->addClause('notAnswered');
        }
        );

        $this->crud->addFilter(
            [ // simple filter
            'type' => 'simple',
            'name' => 'hot',
            'label'=> '热门'
        ],
        false,
        function () {
            $this->crud->addClause('hot');
        }
        );
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
