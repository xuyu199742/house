<?php

namespace App\Models;

trait OfHouse
{
    public function scopeOfHouse($query, $house_id)
    {
        return $query->where('house_id', $house_id);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
