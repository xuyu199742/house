<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Blacklist extends Model
{
    use CrudTrait;

    const BAN_USER = '用户';
    const BAN_IP = 'IP';

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const TYPES = [ '用户', 'IP' ];
    protected $table = 'blacklist';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function ban($type, $data, $memo = '')
    {
        static::create([
            'ban_type' => $type,
            'ban_data' => $data,
            'memo'     => $memo,
        ]);
    }

    public static function check()
    {
        $ip = request()->ip();
        if (static::where('ban_data', $ip)->where('ban_type', static::BAN_IP)->count()) {
            return false;
        }
        if ($user = auth()->user()) {
            if (static::where('ban_data', $user->id)->where('ban_type', static::BAN_USER)->count()) {
                return false;
            }
        }

        return true;
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
