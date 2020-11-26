<?php

namespace App\Models;

trait PhotoUrl
{
    public function getPhotoAttribute()
    {
        if (!$this->attributes['photo']) {
            return image_url('images/placeholder.png');
        }
        return image_url($this->attributes['photo']);
    }

    public function getAvatarAttribute()
    {
        return image_url($this->attributes['avatar']);
    }
}
