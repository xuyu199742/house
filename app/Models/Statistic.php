<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Statistic extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'statistics';
    protected $guarded = [''];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function add($type, $model_id, $action)
    {
        $model = static::where('type', $type)
            ->where('model_id', $model_id)
            ->where('action', $action)
            ->first();
        if (!$model) {
            $model = static::create([
                'type' => $type,
                'model_id' => $model_id,
                'action' => $action,
                'data' => 0
            ]);
        }

        $model->increment('data');
    }

    public static function retrive($type, $model_id, $action)
    {
        $model = static::where('type', $type)
            ->where('model_id', $model_id)
            ->where('action', $action)
            ->first();
        if (!$model) {
            $model = static::create([
                'type' => $type,
                'model_id' => $model_id,
                'action' => $action,
                'data' => 0
            ]);
        }
        return $model->data;
    }

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
