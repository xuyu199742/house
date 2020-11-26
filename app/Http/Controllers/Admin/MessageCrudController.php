<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MessageRequest as StoreRequest;
use App\Http\Requests\MessageRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class MessageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MessageCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Message');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/message');
        $this->crud->setEntityNameStrings('消息通知', '消息通知');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'title',
                'label' => '标题'
            ],
            [
                'name' => 'user_id',
                'label' => '用户ID'
            ],
            [
                'name' => 'created_at',
                'label' => '发送时间'
            ],
            [
                'name' => 'read_at',
                'label' => '阅读时间'
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'user_id',
                'label' => '用户ID',
                'readonly' => true
            ],
            [
                'name' => 'title',
                'label' => '标题'
            ],
            [
                'name' => 'content',
                'label' => '正文',
                'type' => 'textarea'
            ],
            [
                'name' => 'avatar',
                'label' =>'头像',
                'type' => 'browse'
            ],
            [
                'name' => 'author',
                'label' => '来源'
            ],
            [
                'name' => 'link_data',
                'type' => 'link_data',
                'label' => '链接'
            ],
        ]);

        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'title',
                'label'=> '标题'
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'title', 'like', "%{$value}%");
            }
        );

        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'user_id',
                'label'=> '用户ID'
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'user_id', $value);
            }
        );

        $this->crud->addFilter(
            [
                'type' => 'date_range',
                'name' => 'created_at',
                'label'=> '发送时间'
            ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from. '00:00:00');
                $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            }
        );


        // add asterisk for fields that are required in MessageRequest
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
