<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use CrudTrait, SoftDeletes;

    const ACTION_LIKE = 'like';
    const ACTION_TREAD = 'tread';
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'comments';
    protected $guarded = [ 'id' ];

    protected $appends = [ 'replies', 'replies_count', 'publish_at', 'avatar_url', 'is_like', 'is_tread' ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (config('settings.comment_audit')) {
                $model->approved = false;
            } else {
                $model->approved = true;
            }

            if (!$model->user_id) {
                $user = auth()->user();
                if ($user) {
                    $model->user_id  = $user->id;
                    $model->avatar   = $user->avatar;
                    $model->nickname = $user->name;
                }
            }

            $model->ip = request()->ip();
        });

        static::created(function ($model) {
            // 敏感词检查
            $sensitives = Sensitive::all();
            foreach ($sensitives as $sensitive) {
                if (strpos($model->content, $sensitive->word) !== false) {
                    $memo = '禁发词：' . $sensitive->word;
                    $model->update([ 'memo' => $memo ]);

                    if ($sensitive->ban_user) {
                        Blacklist::ban(Blacklist::BAN_USER, $model->user_id, $memo);
                    }

                    if ($sensitive->ban_ip) {
                        Blacklist::ban(Blacklist::BAN_IP, $model->ip, $memo);
                    }

                    switch ($sensitive->handle) {
                        case Sensitive::HANDLE_PENDING:
                            $model->update([ 'approved' => false ]);
                            break;
                        case Sensitive::HANDLE_DELETE:
                            $model->delete();
                            break;
                    }

                    return;
                }
            }
        });
    }

    /**
     * 获取拥有此评论的模型。
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function elite()
    {
        $this->elite = true;
        $this->save();
    }

    public function unElite()
    {
        $this->elite = false;
        $this->save();
    }

    public function approve()
    {
        $this->approved = true;
        $this->save();
    }

    public function reject()
    {
        $this->approved = false;
        $this->save();
    }

    public function action($user = null, $like = true, $remove = false)
    {
        $action = $like ? static::ACTION_LIKE : static::ACTION_TREAD;
        $user   = $user ?: auth()->user();
        if (!$user) {
            return false;
        }
        $liker = $this->likers()->where('user_id', $user->id)->first();
        if ($remove) {
            if ($liker) {
                if ($liker->pivot->action == static::ACTION_LIKE) {
                    $this->decrement('like_count');
                } else {
                    $this->decrement('tread_count');
                }
                $this->likers()->detach($liker->id);

                return true;
            }

            return false;
        }

        if ($liker) {
            $this->decrement($liker->pivot->action.'_count');
            $liker->pivot->action = $action;
            $liker->pivot->save();
        } else {
            $this->likers()->attach($user->id, [ 'action' => $action ]);
        }

        $this->increment($action.'_count');

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function likers()
    {
        return $this->belongsToMany(User::class, 'user_comment', 'comment_id', 'user_id')
            ->withPivot([ 'action' ])
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeIsRoot($query)
    {
        return $query->where('parent_id', null);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getCommentableTitleAttribute()
    {
        $model = $this->commentable;

        return $model->name;
    }

    public function getRepliesAttribute()
    {
        return static::where('parent_id', $this->id)->approved()->take(5)->get();
    }

    public function getRepliesCountAttribute()
    {
        return static::where('parent_id', $this->id)->approved()->count();
    }

    public function getIsLikeAttribute()
    {
        if ($user = auth()->user()) {
            return $this->likers()->wherePivot('action', '=', static::ACTION_LIKE)->where('user_id', $user->id)->count() ? true : false;
        }

        return false;
    }

    public function getIsTreadAttribute()
    {
        if ($user = auth()->user()) {
            return $this->likers()->wherePivot('action', '=', static::ACTION_TREAD)->where('user_id', $user->id)->count() ? true : false;
        }

        return false;
    }

    public function getPublishAtAttribute()
    {
        return human_time($this->attributes[ 'created_at' ]);
    }

    public function getAvatarUrlAttribute()
    {
        return image_url($this->attributes[ 'avatar' ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
