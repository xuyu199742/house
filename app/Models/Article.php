<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Article extends Model
{
    use CrudTrait, PhotoUrl;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    protected $guarded = [ 'id' ];
    protected $hidden = [ 'content' ];
    protected $appends = [ 'publish_at' , 'author', 'avatar'];

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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function houses()
    {
        return $this->belongsToMany(House::class, 'article_house', 'article_id', 'house_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeOfHouse($query, $house_id)
    {
        $house = House::find($house_id);

        return $query->whereIn('id', $house->articles()->pluck('id')->toArray());
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute()
    {
        return $this->title;
    }

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
