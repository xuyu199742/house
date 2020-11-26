<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\House;
use App\Models\Media;
use App\Models\Photo;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ArticleCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Article');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/article');
        $this->crud->setEntityNameStrings('文章', '文章');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => '#'
            ],
            [
                'name'  => 'title',
                'label' => '标题',
                'type' => 'article_title',
                'width' => '34px',
                'height' => '25px',
                'border-radius' => '3px',
            ],
            [
                'name'  => 'category',
                'label' => '分类'
            ],
            [
                'name'  => 'author',
                'label' => '来源'
            ],
            [
                'name'  => 'created_at',
                'label' => '创建时间'
            ],
        ]);

        $this->crud->addFields([
            [
                'name'              => 'category',
                'label'             => '分类',
                'type'              => 'select_from_array',
                'options'           => ArticleCategory::pluck('name', 'name')->toArray(),
                'wrapperAttributes' => [
                    'class' => 'col-md-2 form-group'
                ],
                'tab' => '基本信息'
            ],
            [
                'name'              => 'title',
                'label'             => '标题',
                'wrapperAttributes' => [
                    'class' => 'col-md-10 form-group'
                ],
                'tab' => '基本信息'
            ],
            [
                'name'              => 'photo',
                'label'             => '图片',
                'type'              => 'browse',
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ],
                'tab' => '基本信息'
            ],
            [
                'name'              => 'media_id',
                'label'             => '来源平台',
                'type'              => 'select',
                'entity'            => 'media',
                'model'             => Media::class,
                'attribute'         => 'name',
                'wrapperAttributes' => [
                    'class' => 'col-md-6 form-group'
                ],
                'tab' => '基本信息'
            ],
            [
                'name'  => 'original_link',
                'label' => '原文链接',
                'tab' => '基本信息'
            ],
            [
                'name'  => 'link_data',
                'type'  => 'link_data',
                'label' => '正文链接 (留空则显示正文)',
                'tab' => '基本信息'
            ],
            [
                'name'  => 'content',
                'label' => '正文内容（正文链接为空时才会显示）',
                'type'  => 'wysiwyg',
                'tab' => '基本信息'
            ],
            [
                'name'      => 'houses',
                'label'     => '关联楼盘',
                'type'      => 'checklist',
                'entity'    => 'houses',
                'model'     => House::class,
                'attribute' => 'name',
                'pivot'     => true,
                'tab'       => '关联楼盘'
            ],
        ]);

        // add asterisk for fields that are required in ArticleRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('created_at', 'desc');

        $this->crud->addFilter([
            'name'  => 'category',
            'type'  => 'dropdown',
            'label' => '分类'
        ], ArticleCategory::pluck('name', 'name')->toArray(), function ($value) {
            $this->crud->addClause('where', 'category', $value);
        });

        $this->crud->addFilter([
            'name'  => 'media_id',
            'type'  => 'dropdown',
            'label' => '来源'
        ], Media::pluck('name', 'id')->toArray(), function ($value) {
            $this->crud->addClause('where', 'media_id', $value);
        });

        $this->crud->addFilter([
            'name'  => 'title',
            'type'  => 'text',
            'label' => '标题'
        ], '', function ($value) {
            $this->crud->addClause('where', 'title', 'like', "%{$value}%");
        });

        $this->crud->addFilter([
            'name'  => 'content',
            'type'  => 'text',
            'label' => '正文'
        ], '', function ($value) {
            $this->crud->addClause('where', 'content', 'like', "%{$value}%");
        });

        $this->crud->addButtonFromView('line', 'article', 'article', 'beginning');
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
