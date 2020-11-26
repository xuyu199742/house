<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use CrudTrait;

    protected $table = 'property_types';
    protected $guarded = [''];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->key) {
                $model->key = $model->name;
            }
        });
    }
}
