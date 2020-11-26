<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CommentRequest as StoreRequest;
use App\Http\Requests\CommentRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CommentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CommentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Comment');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/comment');
        $this->crud->setEntityNameStrings('评论', '评论');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'commentable_type',
                'label' => '评论源',
                'type' => 'comment_type'
            ],
            [
                'name' => 'content',
                'label' => '评论内容'
            ],
            [
                'name' => 'approved',
                'label' => '已审核',
                'type' => 'check'
            ],
            [
                'name' => 'elite',
                'label' => '精华',
                'type' => 'check'
            ],
            [
                'name' => 'nickname',
                'label' => '发布用户'
            ],
            [
                'name' => 'created_at',
                'label' => '发布时间'
            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'commentable_type',
                'label' => '评论源',
                'type' => 'select_from_array',
                'options' => [
                    'App\\Models\\House' => '楼盘',
                    'App\\Models\\Article' => '文章',
                ]
            ],
            [
                'name' => 'commentable_id',
                'label' => '评论源ID',
            ],
            [
                'name' => 'content',
                'label' => '评论内容',
                'type' => 'textarea'
            ],
            [
                'name' => 'approved',
                'label' => '已审核',
                'type' => 'checkbox'
            ],
            [
                'name' => 'elite',
                'label' => '精华',
                'type' => 'checkbox'
            ],
            [
                'name' => 'user_id',
                'label' => '用户ID'
            ],
            [
                'name' => 'nickname',
                'label' => '用户昵称'
            ],
            [
                'name' => 'avatar',
                'label' => '用户头像',
                'type' => 'browse'
            ],
            [
                'name' => 'like_count',
                'label' => '点赞数',
                'type' => 'number'
            ],
            [
                'name' => 'tread_count',
                'label' => '点踩数',
                'type' => 'number'
            ],
        ]);

        $this->crud->enableBulkActions();
        $this->crud->addButtonFromView('top', 'bulk_comment_action', 'bulk_comment_action');

        $this->crud->allowAccess('show');
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('created_at', 'desc');

        $this->crud->addFilter([
            'name' => 'commentable_type',
            'type' => 'dropdown',
            'label'=> '评论源'
        ], [
            'App\\Models\\House'   => '楼盘',
            'App\\Models\\Article' => '资讯',
        ], function ($value) {
            $this->crud->addClause('where', 'commentable_type', $value);
        });

        $this->crud->addFilter([
            'name' => 'approved',
            'type' => 'dropdown',
            'label'=> '审核状态'
        ], [
            '1' => '已审核',
            '0' => '未审核'
        ], function ($value) {
            $this->crud->addClause('where', 'approved', $value);
        });

        $this->crud->addFilter([
            'name' => 'elite',
            'type' => 'simple',
            'label'=> '精华'
        ], false, function ($value) {
            if ($value) {
                $this->crud->addClause('where', 'elite', 1);
            }
        });

        $this->crud->addFilter(
            [ // simple filter
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
            [ // daterange filter
            'type' => 'date_range',
            'name' => 'created_at',
            'label'=> '发布时间'
        ],
        false,
        function ($value) { // if the filter is active, apply these constraints
            $dates = json_decode($value);
            $this->crud->addClause('where', 'created_at', '>=', $dates->from. '00:00:00');
            $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
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

    /**
     * 批量加精
     *
     * @return array
     */
    public function bulkElite()
    {
        $ids = request()->get('entries');
        foreach ($ids as $id) {
            $model = Comment::find($id);
            $model->elite();
        }
        return 'ok';
    }

    /**
     * 批量取消加精
     *
     * @return array
     */
    public function bulkUnElite()
    {
        $ids = request()->get('entries');
        foreach ($ids as $id) {
            $model = Comment::find($id);
            $model->unElite();
        }
        return 'ok';
    }

    /**
     * 批量审核
     *
     * @return array
     */
    public function bulkApprove()
    {
        $ids = request()->get('entries');
        foreach ($ids as $id) {
            $model = Comment::find($id);
            $model->approve();
        }
        return 'ok';
    }

    /**
     * 批量取消审核
     *
     * @return array
     */
    public function bulkReject()
    {
        $ids = request()->get('entries');
        foreach ($ids as $id) {
            $model = Comment::find($id);
            $model->reject();
        }
        return 'ok';
    }

    /**
     * 批量删除
     *
     * @return array
     */
    public function bulkDelete()
    {
        $ids = request()->get('entries');
        foreach ($ids as $id) {
            $model = Comment::find($id);
            $model->delete();
        }
        return 'ok';
    }
}
