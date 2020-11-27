<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class House extends Model
{
    use CrudTrait, Tracking, SoftDeletes, PhotoUrl;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const STATUS_PUBLISH = 1;
    const STATUS_DOWN = 2;
    const STATUS_DRAFT = 0;
    const PROPERTY_TYPES = [
        '住宅',
        '公寓',
        '写字楼',
        '别墅',
        '商铺',
        '底商',
    ];

    const SALE_STATUS = [
        '待售',
        '在售',
        '售罄',
        '新盘',
        '即将预售',
        '正在登记',
        '复核结果',
        '等待摇号',
        '摇号完成',
        '摇号结果',
    ];

    protected $table = 'houses';
    protected $guarded = [ 'id' ];
    protected $hidden = [ 'search_meta', 'user' ];
    protected $appends = [ 'is_favor', 'comment_count', 'is_subscribe' ,'qr_url'];
    protected $with = [ 'tags', 'property_types' ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = md5(uniqid());
            }
        });

        static::saving(function ($model) {
            $model->district_id = null;
            if ($model->block_id) {
                $block = Block::find($model->block_id);
                if ($block) {
                    $model->district_id   = $block->district_id;
                    $model->district_name = $block->district->name;
                    $model->block_name    = $block->name;
                }
            }
            $model->reIndex();
        });
    }

    public function reIndex()
    {
        $this->search_meta = $this->name .
            $this->district_name .
            $this->block_name .
            $this->sale_status .
            $this->address .
            $this->search_keywords .
            json_encode($this->tags()->pluck('name'), JSON_UNESCAPED_UNICODE);

        return $this;
    }

    public function publish()
    {
        $this->status = static::STATUS_PUBLISH;
        $this->save();

        return true;
    }

    public function unpublish()
    {
        $this->status = static::STATUS_DOWN;
        $this->save();

        return true;
    }

    public function top()
    {
        $this->is_top = true;
        $this->save();

        return true;
    }

    public function unTop()
    {
        $this->is_top = false;
        $this->save();

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function housetypes()
    {
        return $this->hasMany(Housetype::class);
    }

    public function informations()
    {
        return $this->hasMany(Information::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function property_types()
    {
        return $this->belongsToMany(PropertyType::class, 'house_property', 'house_id', 'property_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_house')->withTimestamps();
        ;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'user_information')->withTimestamps();

    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_house', 'house_id', 'article_id');
    }

    public function residential()
    {
        return $this->belongsTo(Residential::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', static::STATUS_PUBLISH);
    }

    public function scopeOfProprty($query, $property_type_id)
    {
        return $query->whereHas('property_types', function ($q) use ($property_type_id) {
            if (is_array($property_type_id)) {
                $q->whereIn('id', $property_type_id);
            } else {
                $q->where('id', $property_type_id);
            }
        });
    }

    public function scopeOfCategory($query, $category)
    {
        return $query->where('category_' . $category, true);
    }

    public function scopePriceBetween($query, $type, $from, $to)
    {
        return $query->where(function ($_query) use ($type, $from, $to) {
            return $_query->where($type . '_from', '<=', $to)
                ->where($type . '_to', '>=', $from);
        });
    }

    public function scopeAreaBetween($query, $zones)
    {
        return $query->where(function ($_query) use ($zones) {
            foreach ($zones as $zone) {
                $from = $zone[ 0 ];
                $to   = $zone[ 1 ];
                $_query->orWhere(function ($__query) use ($from, $to) {
                    $__query->where('area_from', '<=', $to)
                        ->where('area_to', '>=', $from);
                });
            }

            return $_query;
        });
    }

    public function scopeOfHousetype($query, $housetypes)
    {
        return $query->where(function ($_query) use ($housetypes) {
            $_query->whereExists(function ($__query) use ($housetypes) {
                $__query->select(DB::raw(1))
                    ->from('housetypes')
                    ->whereRaw('housetypes.house_id = houses.id');
                $first = true;

                $__query->where(function ($__query) use ($housetypes) {
                    foreach ($housetypes as $housetype) {
                        $operate = '=';
                        if ($housetype == '>5') {
                            $operate   = '>';
                            $housetype = 5;
                        }
                        $__query->orWhere('housetypes.bedroom_count', $operate, $housetype);
                    }
                });
            });

            return $_query;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getFullLocationAttribute()
    {
        if ($block = $this->block) {
            return $block->district->name . ' - ' . $block->name;
        }

        return '-';
    }

    public function getIsFavorAttribute()
    {
        if (!$user = auth()->user()) {
            return false;
        }

        return $this->users()->where('users.id', $user->id)->count() ? true : false;
    }

    public function getIsSubscribeAttribute()
    {
        if (!$user = auth()->user()) {
            return false;
        }

        return $this->subscribers()->where('users.id', $user->id)->count() ? true : false;
    }

    public function getCommentCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getQrUrlAttribute()
    {
        if ($user = $this->user) {
            return $user->qr_url ? image_url($user->qr_url) : null;
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
