<?php

namespace App\Http\Controllers\Admin;

use App\Models\Block;
use App\Models\District;
use App\Models\House;
use App\Models\PropertyType;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\HouseRequest as StoreRequest;
use App\Http\Requests\HouseRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use function PHPSTORM_META\type;

/**
 * Class HouseCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class HouseCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\House');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/house');
        $this->crud->setEntityNameStrings('房源', '房源');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name'  => 'id',
                'label' => '房源编号',
            ],
            [
                'name'  => 'name',
                'label' => '房源名称',
                'type'  => 'house_title',
                'width' => '34px',
                'height' => '25px',
                'border-radius' => '3px',
            ],
            [
                'name'  => 'district_name',
                'label' => '区域',
            ],
            [
                'name'    => 'status',
                'label'   => '数据状态',
                'type'    => 'select_from_array',
                'options' => [
                    '1' => '已上架',
                    '2' => '已下架',
                    '0' => '草稿'
                ],
            ],
//            [
//                'name'  => 'user_id',
//                'label' => '负责人',
//                'type' => 'user'
//            ],
        ]);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => '房源名称',
                'tab'   => '基本信息',
            ],
            [
                'name'  => 'title',
                'label' => '房源标题',
                'tab'   => '基本信息',
            ],
            [
                'label'     => "标签",
                'type'      => 'select2_multiple',
                'name'      => 'tags',
                'entity'    => 'tags',
                'attribute' => 'name',
                'model'     => "App\Models\Tag",
                'pivot'     => true,
                'tab'       => '基本信息'
            ],
            [
                'name'  => 'photo',
                'label' => '缩略图',
                'type'  => 'browse',
                'tab'   => '基本信息',
            ],
            [
                'name'   => 'house_area',
                'label'  => '建筑面积',
                'type'   => 'number',
                'tab'    => '基本信息',
                'suffix' => '㎡',
            ],
    //            [
    //                'name'  => 'user_id',
    //                'label' => '负责人',
    //                'type'  => 'select_from_array',
    //                'allows_null' => true,
    //                'options' => User::employee()->pluck('name', 'id')->toArray(),
    //                'tab'   => '基本信息',
    //            ],
//            [
//                'name'    => 'sale_status',
//                'label'   => '房源状态',
//                'tab'     => '基本信息',
//                'type'    => 'select_from_array',
//                'options' => array_combine(House::SALE_STATUS, House::SALE_STATUS),
//            ],
            [
                'label'                      => '区属',
                'type'                       => 'select_grouped',
                'name'                       => 'block_id',
                'entity'                     => 'block',
                'attribute'                  => 'name',
                'group_by'                   => 'district',
                'group_by_attribute'         => 'name',
                'group_by_relationship_back' => 'blocks',
                'tab'                        => '基本信息'
            ],
            [
                'name'  => 'address',
                'label' => '房源地址',
                'type'  => 'map',
                'tab'   => '基本信息'
            ],
            [
                'label' => "所属小区",
                'type' => 'select2',
                'name' => 'residential_id',
                'entity' => 'residential',
                'attribute' => 'name',
                'model' => "App\Models\Properties",
                'tab'    => '基本信息',
            ],
//            [
//                'label'     => "选择物业",
//                'type'      => 'select2',
//                'name'      => 'properties_id',
//                'entity'    => 'properties',
//                'attribute' => 'name',
//                'model'     => "App\Models\Properties",
//                'tab'       => '基本信息'
//            ],
//            [
//                'name'  => 'sales_address',
//                'label' => '物业地址',
//                'tab'   => '基本信息'
//            ],
//            [
//                'name'  => 'sales_phone',
//                'label' => '物业电话',
//                'tab'   => '基本信息'
//            ],
            [
                'name'   => 'price',
                'label'  => '单价',
                'suffix' => '元/㎡',
                'tab'    => '详细信息',
            ],
            [
                'name'  => 'orientation',
                'label' => '朝向',
                'tab'   => '详细信息',
            ],
            [
                'name'   => 'display_price',
                'label'  => '售价',
                'suffix' => '万元',
                'tab'    => '详细信息',
            ],
            [
                'name'  => 'room_type',
                'label' => '房型',
                'tab'   => '详细信息'
            ],
            [
                'name'        => 'decorate',
                'label'       => '装修风格',
                'type'        => 'select_from_array',
                'options'     => [
                    'no'      => '毛坯',
                    'yes'     => '精装',
                    'default' => '其他'
                ],
                'allows_null' => true,
                'tab'         => '详细信息',
            ],
            [
                'name'                => 'open_at',
                'label'               => '挂盘时间',
                'readonly'            => false,
                'type'                => 'date_picker',
                'tab'                 => '详细信息',
                'date_picker_options' => [
                    'todayHighlight' => true,
                    'clearBtn'       => true,
                    'format'         => 'yyyy-mm-dd',
                    'language'       => "zh-CN",
                ],
            ],
            [
                'name'  => 'desc',
                'label' => '房源介绍',
                'type'  => 'textarea',
                'tab'   => '详细信息',
            ],
            [
                'label'     => '房源用途',
                'type'      => 'checklist',
                'name'      => 'property_types',
                'entity'    => 'property_types',
                'attribute' => 'name',
                'model'     => PropertyType::class,
                'pivot'     => true,
                'tab'       => '详细信息',
            ],
//            [
//                'name'   => 'number_of_year',
//                'label'  => '产权年限',
//                'suffix' => '年',
//                'tab'    => '详细信息',
//            ],
//            [
//                'name'  => 'developer',
//                'label' => '开发商',
//                'tab'   => '详细信息',
//            ],
//            [
//                'name'   => 'area',
//                'label'  => '占地面积',
//                'tab'    => '详细信息',
//                'suffix' => '㎡',
//            ],

//            [
//                'name'  => 'plot_ratio',
//                'label' => '容积率',
//                'tab'   => '详细信息',
//            ],
//            [
//                'name'   => 'greening_rate',
//                'label'  => '绿化率',
//                'tab'    => '详细信息',
//                'suffix' => '%',
//            ],
//            [
//                'name'   => 'parking',
//                'label'  => '车位配比',
//                'tab'    => '详细信息',
//            ],
//            [
//                'name'  => 'building_count',
//                'label' => '楼栋数',
//                'tab'   => '详细信息',
//            ],
//            [
//                'name'  => 'house_count',
//                'label' => '总户数',
//                'tab'   => '详细信息',
//                'suffix' => '户',
//            ],
//            [
//                'name'  => 'property_management',
//                'label' => '物业公司',
//                'tab'   => '详细信息',
//            ],
//            [
//                'name'   => 'service_price',
//                'label'  => '物业费',
//                'suffix' => '元/㎡•月',
//                'tab'    => '详细信息',
//            ],
            [
                'name'  => 'level_desc',
                'label' => '楼层',
                'tab'   => '详细信息',
            ],

            [
                'name'  => 'building_type',
                'label' => '楼型',
                'tab'   => '详细信息',
            ],
            [   // radio
                'name'        => 'elevator', // the name of the db column
                'label'       => '电梯', // the input label
                'type'        => 'radio',
                'inline'      => true,
                'options'     => [
                    0 => "没有",
                    1 => "有"
                ],
                'tab'   => '详细信息',
            ],
            [
                'name'                => 'years',
                'label'               => '年代',
                'tab'                 => '详细信息',
                'type'                => 'number',
                'suffix'              => '年',
            ],
            [
                'name'  => 'ownership',
                'label' => '权属',
                'tab'   => '详细信息',
            ],

            [
                'name'  => 'around_traffic',
                'label' => '公共交通',
                'type'  => 'textarea',
                'tab'   => '周边设置',
            ],
            [
                'name'  => 'around_school',
                'label' => '周边学校',
                'type'  => 'textarea',
                'tab'   => '周边设置',
            ],
            [
                'name'  => 'around_shop',
                'label' => '综合商场',
                'type'  => 'textarea',
                'tab'   => '周边设置',
            ],
            [
                'name'  => 'around_hospital',
                'label' => '周边医院',
                'type'  => 'textarea',
                'tab'   => '周边设置',
            ],
            [
                'name'  => 'around_park',
                'label' => '周边公园',
                'type'  => 'textarea',
                'tab'   => '周边设置',
            ],
            [
                'name'  => 'around_bank',
                'label' => '周边银行',
                'type'  => 'textarea',
                'tab'   => '周边设置',
            ],
            [
                'name'  => 'total_view',
                'label' => '浏览人数',
                'type'  => 'number',
                'tab'   => '房源数据',
            ],
            [
                'name'  => 'total_favor',
                'label' => '关注人数',
                'type'  => 'number',
                'tab'   => '房源数据',
            ],
//            [
//                'name'  => 'category_1',
//                'label' => '热门房源',
//                'type'  => 'checkbox',
//                'wrapperAttributes' => [
//                    'class' => 'form-group col-md-2'
//                ],
//                'tab'   => '搜索优化',
//            ],
//            [
//                'name'  => 'category_2',
//                'label' => '最新房源',
//                'type'  => 'checkbox',
//                'wrapperAttributes' => [
//                    'class' => 'form-group col-md-2'
//                ],
//                'tab'   => '搜索优化',
//            ],
//            [
//                'name'  => 'category_3',
//                'label' => '即将预售',
//                'type'  => 'checkbox',
//                'wrapperAttributes' => [
//                    'class' => 'form-group col-md-2'
//                ],
//                'tab'   => '搜索优化',
//            ],
//            [
//                'name'  => 'category_4',
//                'label' => '最新摇号',
//                'type'  => 'checkbox',
//                'wrapperAttributes' => [
//                    'class' => 'form-group col-md-2'
//                ],
//                'tab'   => '搜索优化',
//            ],
//            [
//                'name'  => 'category_5',
//                'label' => '摇号剩余',
//                'type'  => 'checkbox',
//                'wrapperAttributes' => [
//                    'class' => 'form-group col-md-2'
//                ],
//                'tab'   => '搜索优化',
//            ],
//            [
//                'name'   => 'price_from',
//                'label'  => '单价(最低)',
//                'suffix' => '元/㎡',
//                'tab'    => '搜索优化',
//            ],
//            [
//                'name'   => 'price_to',
//                'label'  => '单价(最高)',
//                'suffix' => '元/㎡',
//                'tab'    => '搜索优化',
//            ],
//            [
//                'name'   => 'amount_from',
//                'label'  => '总价(最低)',
//                'suffix' => '万元',
//                'tab'    => '搜索优化',
//            ],
//            [
//                'name'   => 'amount_to',
//                'label'  => '总价(最高)',
//                'suffix' => '万元',
//                'tab'    => '搜索优化',
//            ],
//            [
//                'name'   => 'area_from',
//                'label'  => '面积(最低)',
//                'suffix' => '㎡',
//                'tab'    => '搜索优化',
//            ],
//            [
//                'name'   => 'area_to',
//                'label'  => '面积(最高)',
//                'suffix' => '㎡',
//                'tab'    => '搜索优化',
//            ],
//            [
//                'name'  => 'search_keywords',
//                'label' => '搜索关键词 (逗号分隔)',
//                'tab'   => '搜索优化',
//            ],
        ]);

        $this->crud->enableBulkActions();

        $this->crud->addButtonFromView('top', 'bulk_publish', 'bulk_publish');
        $this->crud->addButtonFromView('line', 'publish_action', 'publish_action');
//        $this->crud->addButtonFromView('line', 'top_action', 'top_action');

        // add asterisk for fields that are required in HouseRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->allowAccess('show');
        $this->crud->setShowView('house.show');

        if (request('trashed')) {
            $this->crud->addClause('onlyTrashed');
        }

        $this->crud->addFilter([
            'name'  => 'id',
            'type'  => 'text',
            'label' => '房源编号'
        ], '', function ($value) {
            $this->crud->addClause('where', 'id', $value);
        });

        $this->crud->addFilter([
            'name'  => 'name',
            'type'  => 'text',
            'label' => '房源名称'
        ], '', function ($value) {
            $this->crud->addClause('where', 'name', 'like', "%{$value}%");
        });

        $this->crud->addFilter([
            'name'  => 'district_id',
            'type'  => 'dropdown',
            'label' => '房源区域'
        ], District::pluck('name', 'id')->toArray(), function ($value) {
            $this->crud->addClause('where', 'district_id', $value);
        });

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => '数据状态'
        ], [
            '1' => '已上架',
            '0' => '已下架'
        ], function ($value) {
            $this->crud->addClause('where', 'status', $value);
        });

//        $this->crud->addFilter([
//            'name'  => 'user_id',
//            'type'  => 'dropdown',
//            'label' => '负责人'
//        ], User::employee()->pluck('name', 'id')->toArray(), function ($value) {
//            $this->crud->addClause('where', 'user_id', $value);
//        });

//        $this->crud->addFilter([
//            'name'  => 'category',
//            'type'  => 'dropdown',
//            'label' => '房源分类'
//        ], [
//            'category_1' => '热门房源',
//            'category_2' => '最新房源',
//            'category_3' => '即将预售',
//            'category_4' => '最新摇号',
//            'category_5' => '摇号剩余',
//        ], function ($value) {
//            $this->crud->addClause('where', $value, 1);
//        });

//        $this->crud->addFilter([
//            'name'  => 'sale_status',
//            'type'  => 'dropdown',
//            'label' => '销售状态'
//        ], array_combine(House::SALE_STATUS, House::SALE_STATUS), function ($value) {
//            $this->crud->addClause('where', 'sale_status', $value);
//        });

        $this->crud->orderBy('is_top', 'desc');
        $this->crud->orderBy('id', 'desc');
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
     * 发布房源信息
     *
     * @param $house_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish($house_id)
    {
        $house = House::find($house_id);
        $house->publish();
        \Alert::success('房源 <b>' . $house->name . '</b> 上架成功')->flash();

        return redirect()->back();
    }

    /**
     * 下架
     *
     * @param $house_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unpublish($house_id)
    {
        $house = House::find($house_id);
        $house->unpublish();
        \Alert::success('房源 <b>' . $house->name . '</b> 下架成功')->flash();

        return redirect()->back();
    }

    /**
     * 置顶房源信息
     *
     * @param $house_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function top($house_id)
    {
        $house = House::find($house_id);
        $house->top();
        \Alert::success('房源 <b>' . $house->name . '</b> 置顶成功')->flash();

        return redirect()->back();
    }

    /**
     * 取消置顶房源信息
     *
     * @param $house_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unTop($house_id)
    {
        $house = House::find($house_id);
        $house->unTop();
        \Alert::success('房源 <b>' . $house->name . '</b> 取消置顶成功')->flash();

        return redirect()->back();
    }

    /**
     * 批量发布
     *
     * @return array
     */
    public function bulkPublish()
    {
        $house_ids = request()->get('entries');
        foreach ($house_ids as $house_id) {
            $house = House::find($house_id);
            $house->publish();
        }

        return request()->all();
    }

    /**
     * 批量下架
     *
     * @return array
     */
    public function bulkUnpublish()
    {
        $house_ids = request()->get('entries');
        foreach ($house_ids as $house_id) {
            $house = House::find($house_id);
            $house->unpublish();
        }

        return request()->all();
    }

    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');
        $this->crud->setOperation('show');

        $id = $this->crud->getCurrentEntryId() ?? $id;
        // get the info for that entry
        $this->data[ 'house' ] = $this->crud->getEntry($id);
        $this->data[ 'title' ] = $this->crud->getTitle() ?? trans('backpack::crud.preview') . ' ' . $this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getShowView(), $this->data);
    }

    public function restore($id)
    {
        $model = House::onlyTrashed()->find($id);
        if ($model) {
            $model->restore();

            return 1;
        }

        return 0;
    }
}
