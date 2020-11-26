<?php

namespace App\Models;

use App\Jobs\SendInformationNotificationJob;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Information extends Model
{
    use CrudTrait, OfHouse;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const TYPES = [ '楼盘新闻', '预售开盘', '摇号选房' ];

    protected $table = 'informations';
    protected $guarded = [ 'id' ];
    protected $appends = [ 'avatar', 'author', 'publish_at' ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if ($model->notify) {
                dispatch(new SendInformationNotificationJob($model->id));
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

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

    public function getPublishAtAttribute()
    {
        return human_time($this->attributes[ 'created_at' ]);
    }

    public function getAuthorAttribute()
    {
        if ($media = $this->media) {
            return $media->name;
        }

        return '';
    }

    public function getAvatarAttribute()
    {
        if ($media = $this->media) {
            return $media->avatar;
        }

        return '';
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
