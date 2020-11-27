<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [ 'web', config('backpack.base.middleware_key', 'admin') ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    CRUD::resource('house', 'HouseCrudController', ['middleware'=>['permission:'.\App\Models\Permission::PERMISSION_HOUSE]])->with(function () {
        Route::post('house/bulk-publish', 'HouseCrudController@bulkPublish');
        Route::post('house/bulk-unpublish', 'HouseCrudController@bulkUnpublish');
        Route::get('house/{id}/publish', 'HouseCrudController@publish')->name('crud.house.publish');
        Route::get('house/{id}/unpublish', 'HouseCrudController@unpublish')->name('crud.house.unpublish');
        Route::get('house/{id}/top', 'HouseCrudController@top')->name('crud.house.top');
        Route::get('house/{id}/untop', 'HouseCrudController@unTop')->name('crud.house.untop');

        Route::post('house/{id}/restore', 'HouseCrudController@restore')->name('crud.house.restore');

        CRUD::resource('house/{house_id}/photo', 'PhotoCrudController');
        CRUD::resource('house/{house_id}/housetype', 'HousetypeCrudController');
        CRUD::resource('house/{house_id}/information', 'InformationCrudController');
    });

    Route::group(['middleware' => [ 'permission:'.\App\Models\Permission::PERMISSION_CONFIG]], function () {

        // 标签配置
        CRUD::resource('tag', 'TagCrudController');

        // 地铁配置
        CRUD::resource('subway', 'SubwayCrudController')->with(function () {
            CRUD::resource('subway/{subway_id}/station', 'StationCrudController');
        });

        // 区属配置
        CRUD::resource('district', 'DistrictCrudController')->with(function () {
            CRUD::resource('district/{district_id}/block', 'BlockCrudController');
        });

        Route::get('homeconfig', 'PageController@homeConfig');
        Route::post('homeconfig/add', 'HomeconfigController@add');
        Route::post('homeconfig/sort', 'HomeconfigController@sort');
        Route::post('homeconfig/remove/{id}', 'HomeconfigController@remove');

        // 广告位配置
        CRUD::resource('sponsor', 'SponsorCrudController');

        // 热搜词配置
        CRUD::resource('hotsearch', 'HotsearchCrudController');

        // 首页配置
        CRUD::resource('frontpage', 'FrontpageCrudController');

        // 快捷路径配置
        CRUD::resource('shortcut', 'ShortcutCrudController');

        // 物业
        CRUD::resource('properties', 'PropertiesCrudController');
        CRUD::resource('residential', 'ResidentialCrudController');

        // 底部导航配置
        CRUD::resource('tab', 'TabCrudController');

        // 来源平台配置
        CRUD::resource('media', 'MediaCrudController');
        CRUD::resource('article_category', 'ArticleCategoryCrudController');
    });

    // 资讯管理
    CRUD::resource('article', 'ArticleCrudController', ['middleware' => [ 'permission:'.\App\Models\Permission::PERMISSION_ARTICLE]]);
    // 用户行为
    CRUD::resource('tracker', 'TrackerCrudController', ['middleware' => [ 'permission:'.\App\Models\Permission::PERMISSION_TRACKER]]);

    // 评论管理
    CRUD::resource('comment', 'CommentCrudController', ['middleware' => [ 'permission:'.\App\Models\Permission::PERMISSION_COMMENT]])->with(function () {
        Route::post('comment/bulk-elite', 'CommentCrudController@bulkElite');
        Route::post('comment/bulk-unelite', 'CommentCrudController@bulkUnElite');
        Route::post('comment/bulk-approve', 'CommentCrudController@bulkApprove');
        Route::post('comment/bulk-reject', 'CommentCrudController@bulkReject');
        Route::post('comment/bulk-delete', 'CommentCrudController@bulkDelete');
    });

    // 交易数据
    CRUD::resource('transaction', 'TransactionCrudController', ['middleware' => [ 'permission:'.\App\Models\Permission::PERMISSION_DATA]]);

    // 答疑
    CRUD::resource('question', 'QuestionCrudController', ['middleware' => [ 'permission:'.\App\Models\Permission::PERMISSION_QUESTION]]);

    // 敏感词
    CRUD::resource('sensitive', 'SensitiveCrudController');
    // 黑名单
    CRUD::resource('blacklist', 'BlacklistCrudController');
    CRUD::resource('users', 'UserCrudController');

    CRUD::resource('systemlog', 'SystemLogCrudController');
    CRUD::resource('homeconfigcategory', 'HomeconfigCategoryCrudController');
    CRUD::resource('message', 'MessageCrudController');
    CRUD::resource('propertytype', 'PropertyTypeCrudController');
    CRUD::resource('page', 'PageCrudController');


    Route::get('linklist', 'PageController@linkList');
    Route::get('images', 'PageController@images');
}); // this should be the absolute last line of this file
