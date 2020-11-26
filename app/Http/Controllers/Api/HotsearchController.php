<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotsearch;

/**
 * Class HouseController
 *
 * @package App\Http\Controllers\Api
 */
class HotsearchController extends ApiController
{
    public function index()
    {
        return $this->success(Hotsearch::orderBy('order', 'desc')->get());
    }
}
