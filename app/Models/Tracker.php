<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;

class Tracker extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'trackers';
    protected $guarded = [ 'id' ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function record($action_name = null, $action_param = null)
    {
        if (!request('action')) {
            return;
        }
        static::create([
            'action'   => $action_name ?? request('action'),
            'data'     => $action_param ?? request('data'),
            'page'     => $action_param ?? request('page'),
            'user_id'  => auth()->id() ?? null,
            'platform' => request()->header('Platform'),
            'ip'       => request()->ip()
        ]);
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

    public function getPageAttribute()
    {
        return trans('track.page.' . $this->attributes[ 'page' ]);
    }

    public function getActionAttribute()
    {
        return trans('track.' . $this->attributes[ 'page' ] . '.' . $this->attributes[ 'action' ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
