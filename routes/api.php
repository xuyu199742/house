<?php

Route::group([
    'middleware' => 'api',
    'prefix'     => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::any('wechat/login', 'WechatController@login');
Route::any('wechat/pay', 'WechatController@pay');
Route::post('wechat/mobile', 'WechatController@loginWithMobile');
Route::post('wechat/username', 'WechatController@loginWithUsername');

Route::group([
    'middleware' => 'auth:api',
    'prefix'     => 'wechat'
], function () {
    Route::post('profile', 'WechatController@updateUserInfo');

});

Route::group([
    'namespace' => '\App\Http\Controllers\Api',
], function () {
    Route::any('qr', 'PageController@qrcode');
    Route::any('track', 'PageController@track');

    Route::get('index', 'PageController@index');
    Route::get('init', 'PageController@init');
    Route::get('house_quicksearch', 'HouseController@quickSearch');

    Route::get('house', 'HouseController@index');

    Route::get('house/{id}/photo', 'HouseController@photos');
    Route::get('house/{id}/housetype', 'HouseController@houseTypes');
    Route::get('house/{id}/information', 'HouseController@informations');

    Route::get('house/{id}/comment', 'HouseController@comments');
    Route::get('house/{id}/comment/{comment_id}', 'HouseController@comment');

    Route::get('house/{id}/article', 'HouseController@articles');

    Route::get('house/{id}', 'HouseController@show');
    Route::get('house/{id}/detail', 'HouseController@detail');

    Route::get('comment/{id}', 'CommentController@show');

    Route::get('article', 'ArticleController@index');
    Route::get('article/{id}', 'ArticleController@show');

    Route::get('question', 'QuestionController@index');
    Route::get('question/{id}', 'QuestionController@show');

    Route::get('hotsearch', 'HotsearchController@index');
    Route::get('transaction', 'TransactionController@index');

    Route::get('summary', 'PageController@summary');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('my_question', 'QuestionController@mine');
        Route::get('my_house', 'HouseController@mine');
        Route::get('message', 'PageController@message');
        Route::post('delete_message/{id}', 'PageController@deleteMessage');
        Route::post('question', 'QuestionController@store');
        Route::post('article/{id}/comment', 'ArticleController@submitComment');
        Route::post('house/{id}/comment', 'HouseController@submitComment');
        Route::post('house/{id}/favorite', 'HouseController@favorite');
        Route::post('house/{id}/remove_favorite', 'HouseController@removeFavorite');
        Route::post('house/{id}/subscribe', 'HouseController@subscribe');
        Route::post('house/{id}/remove_subscribe', 'HouseController@removeSubscribe');
        Route::post('info', 'PageController@profile');

        Route::post('comment_like/{id}', 'CommentController@like');
        Route::post('comment_cancel_like/{id}', 'CommentController@cancelLike');
        Route::post('comment_tread/{id}', 'CommentController@tread');
        Route::post('comment_cancel_tread/{id}', 'CommentController@cancelTread');
    });
});
