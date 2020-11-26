<?php

namespace App\Models;

trait Tracking
{
    public function view()
    {
        return $this->updateStatistics('view');
    }

    public function like()
    {
        return $this->updateStatistics('like');
    }

    public function getViewCountAttribute()
    {
        return $this->retriveStatistics('view');
    }

    public function getLikeCountAttribute()
    {
        return $this->retriveStatistics('like');
    }

    private function updateStatistics($action)
    {
        Statistic::add(self::class, $this->id, $action);
    }

    private function retriveStatistics($action)
    {
        return Statistic::retrive(self::class, $this->id, $action);
    }
}
