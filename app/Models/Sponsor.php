<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Sponsor extends Model
{
    use CrudTrait, Intime, PhotoUrl;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const POSITION_TOP = 'top';
    const POSITION_TAPES = 'tapes';
    const POSITION_SEARCH = 'search';
    const POSITION_FOOTER = 'footer';
    const POSITION_START = 'start';
    const POSITION_FLOAT = 'float';
    const POSITION_ARTICLE = 'article';
    const POSITION_QUESTION = 'question';
    const POSITION_HOUSE_DETAIL = 'house_detail';

    const POSITIONS = [
        'start'        => '开屏广告',
        'top'          => '首页顶部',
//        'footer'       => '首页底部',
//        'float'        => '首页浮动',
        'tapes'        => '首页腰封',
        'house_detail' => '房产详情页腰封',
        'search'       => '搜索结果页',
        'article'      => '文章首页',
        'question'     => '答疑首页',
    ];

    protected $table = 'sponsors';
    protected $guarded = [ 'id' ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
