<?php

namespace App;

use App\Models\House;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Backpack\Base\app\Models\Traits\InheritsRelationsFromParentModel;
use DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use CrudTrait;
    use HasRoles;
    use InheritsRelationsFromParentModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'is_admin',
        'email',
        'mobile',
        'country_code',
        'pure_phone_number',
        'wechat_updated_at',
        'mobile_updated_at',
        'email_verified_at',
        'password',
        'openid',
        'avatar',
        'gender',
        'language',
        'country',
        'city',
        'province',
        'session_key',
        'profile_name',
        'profile_id',
        'qr_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'id', 'session_key', 'openid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => 'string',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function houses()
    {
        return $this->belongsToMany(House::class, 'user_house')->withTimestamps();
    }

    public function scopeEmployee($query)
    {
        return $query->whereExists(function ($q) {
            $q->select(DB::raw(1))
                ->from('model_has_roles')
                ->whereRaw('model_has_roles.model_id = users.id');
        });
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar_url();
    }

    public function getMaskMobileAttribute()
    {
        if ($mobile = $this->attributes['mobile']) {
            return substr($mobile, 0, 3).'******'.substr($mobile, 9);
        }
        return '-';
    }

    public function avatar_url()
    {
        if ($this->attributes[ 'avatar' ]) {
            return url($this->attributes[ 'avatar' ]);
        }

        return url(config('settings.default_avatar'));
    }
}
