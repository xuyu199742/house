<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Housetype extends Model
{
    use CrudTrait, OfHouse;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'housetypes';
    protected $guarded = [ 'id' ];
    protected $appends = [ 'photos_url' ];


    const PRICE_TYPE = [
        'unit'  => '每平米',
        'total' => '每套'
    ];

    const SALE_STATUS = [
        '在售'  => '在售',
        '未开盘' => '未开盘',
        '已售罄' => '已售罄'
    ];

    protected $casts = [
        'photos' => 'array'
    ];

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

    public function getDisplayPriceAttribute()
    {
        $price_type = static::PRICE_TYPE[ $this->attributes[ 'price_type' ] ];

        return $this->attributes[ 'price' ] . '/' . $price_type;
    }

    public function getPhotoAttribute()
    {
        return image_url($this->attributes[ 'photo' ]);
    }

    public function getPhotosUrlAttribute()
    {
        $result = [];

        if (is_array($this->photos)) {
            foreach ($this->photos as $photo) {
                $result[] = image_url($photo);
            }
        }

        return $result;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

//    public function setPhotosAttribute($value)
//    {
//        $attribute_name = "photos";
//        $disk = "public";
//        $destination_path = "/";
//
//        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
//    }
}
