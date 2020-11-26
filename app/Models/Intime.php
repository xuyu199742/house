<?php

namespace App\Models;

use Carbon\Carbon;

trait Intime
{
    public function scopeIntime($query)
    {
        return $query->where(function ($query) {
            return $query->where('start', '<=', Carbon::now())
                ->orWhereNull('start');
        })->where(function ($query) {
            return $query->where('end', '>', Carbon::now())
                ->orWhereNull('end');
        });
    }

    public function scopeStarted($query)
    {
        return $query->where('start', '<=', Carbon::now())
            ->orWhereNull('start');
    }

    public function scopeNotEnd($query)
    {
        return $query->where('end', '>', Carbon::now())
            ->orWhereNull('end');
    }
}
