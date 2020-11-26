<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function linkList()
    {
        return view('linklist');
    }

    public function homeConfig()
    {
        return view('home_config');
    }

    public function images()
    {
        return view('images');
    }
}
