<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homeconfig;
use App\Models\House;
use Illuminate\Http\Request;

class HomeconfigController extends Controller
{
    public function add()
    {
        $house_id = request('house_id');
        $house = House::find($house_id);

        if (!$house) {
            return response()->json([
                'error' => true,
                'message' => '房源不存在'
            ], 404);
        }
        $category =  request('category');
        if (Homeconfig::ofCategory($category)->where('house_id', $house_id)->count()) {
            return response()->json([
                'error' => true,
                'message' => '记录已经存在, 请勿重复添加'
            ], 401);
        }
        $model = Homeconfig::create([
            'house_id' => $house->id,
            'category' => $category
        ]);

        return $model;
    }

    public function remove($id)
    {
        $model = Homeconfig::findOrFail($id);
        $model->delete();
        return $model;
    }

    public function sort()
    {
        $category_id = request()->get('category_id');
        Homeconfig::ofCategory($category_id)->delete();
        $house_ids =request()->get('house_ids');
        foreach ($house_ids as $house_id) {
            Homeconfig::create([
                'house_id' => $house_id,
                'category' => $category_id
            ]);
        }
        return 'ok';
    }
}
