<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/article/{id}/preview', function ($id) {
    $article = \App\Models\Article::findOrFail($id);
    return view('article')->with(compact('article'));
});

Route::get('/page/{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug', $slug)->orWhere('id', $slug)->first();
    if (!$page) {
        abort(404);
    }

    return view('page')->with(compact('page'));
});
