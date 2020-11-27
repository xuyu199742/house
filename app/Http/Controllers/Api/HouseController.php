<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Comment;
use App\Models\House;
use App\Models\Photo;
use App\Models\Tag;

/**
 * Class HouseController
 *
 * @package App\Http\Controllers\Api
 */
class HouseController extends ApiController
{
    public function index()
    {
        $per_page = request('per_page') ?? 10;

        $builder = House::query()->select(
            ['id', 'name', 'title', 'hall' ,'room', 'orientation', 'price', 'display_price', 'photo', 'house_area']
        )->published();

        // 关键词
        if ($keyword = request('keyword')) {
            $builder->where('search_meta', 'like', '%' . $keyword . '%');
        }

        if ($filters = request('filters')) {
            $filters = json_decode($filters, true);
            if ($filters) {
                foreach ($filters as $key => $filter) {
                    if (!$filter) {
                        continue;
                    }
                    switch ($key) {
                        case 'zone':
                            foreach ($filter as $_district_id => $_block_ids) {
                                if ($_district_id) {
                                    $builder->where('district_id', $_district_id);
                                    if (count($_block_ids)) {
                                        $builder->whereIn('block_id', $_block_ids);
                                    }
                                }
                            }
                            break;
                        case 'price':
                            foreach ($filter as $_price_type => $_price_zone) {
                                $_price_zone = explode('-', $_price_zone[0] ?? '-');

                                $from = $_price_zone[0] ?? 0;
                                $to = $_price_zone[1] ?? INF;

                                $builder->priceBetween($_price_type, $from, $to);
                            }
                            break;
                        case 'area':
                            $area_zones = [];
                            foreach ($filter as $_area_zone => $_value) {
                                $_area_zone = explode('-', $_area_zone ?? '-');

                                $from = $_area_zone[0] ?? 0;
                                $to = $_area_zone[1] ?? INF;
                                $area_zones [] = [
                                    $from, $to
                                ];
                            }
                            $builder->areaBetween($area_zones);
                            break;
                        case 'housetype':
                            $housetypes = [];
                            foreach ($filter as $_housetype => $_value) {
                                if ($_value) {
                                    $housetypes [] = $_housetype;
                                }
                            }
                            $builder->ofHousetype($housetypes);
                            break;
                        case 'decoration':
                            foreach ($filter as $decoration => $_value) {
                                $builder->where('decorate', $decoration);
                            }
                            break;
                    }
                }
            }
        }

        if ($type = request()->get('type')) {
            $builder->ofCategory($type);
        }

        $models = $builder->paginate($per_page);

        return $this->success($models);
    }

    public function mine()
    {
        $user = auth()->user();

        $builder = $user->houses()->where('status', House::STATUS_PUBLISH);
        $models = $builder->paginate();

        return $this->success($models);
    }

    public function show($id)
    {
        $house = House::query()->select(
            ['id', 'name', 'title', 'hall' ,'room', 'orientation', 'price', 'decorate', 'orientation', 'house_area', 'ownership',
                'display_price', 'open_at', 'level_desc', 'building_type', 'orientation', 'years', 'residential_id', 'around_traffic',
                'around_school', 'around_shop', 'around_bank', 'around_hospital', 'around_park'
            ]
        )->with('residential.properties')->findOrFail($id);
//        $house->view();
//        $house->increment('total_view');
//        $comments     = $house->comments()->approved()->isRoot()->orderBy('created_at', 'desc')->take(4)->get();
//        $articles     = $house->articles()->orderBy('created_at', 'desc')->take(4)->get();
//        $informations = $house->informations()->orderBy('created_at', 'desc')->take(4)->get();
//        $recommends   = House::published()->inRandomOrder()->take(3)->get();
        $photos = Photo::ofHouse($house->id)->ofCategory('封面图')->take(10)->get();

        return $this->success([
            'house' => $house,
//            'comments'     => $comments,
//            'articles'     => $articles,
//            'informations' => $informations,
//            'recommends'   => $recommends,
            'photos' => $photos,
        ]);
    }

    public function detail($id)
    {
        $house = House::findOrFail($id);

        return $this->success($house);
    }

    public function photos($id)
    {
        $house = House::with('photos')->findOrFail($id);

        return $this->success($house);
    }

    public function houseTypes($id)
    {
        $house = House::findOrFail($id);

        return $this->success($house);
    }

    public function informations($id)
    {
        $house = House::findOrFail($id);
        $builder = $house->informations()->orderBy('created_at', 'desc');
        if ($category = request()->get('category')) {
            if ('全部' != $category) {
                $builder->where('type', $category);
            }
        }
        $models = $builder->paginate();

        return $this->success([
            'house' => $house,
            'informations' => $models
        ]);
    }

    public function comments($id)
    {
        $house = House::findOrFail($id);
        $models = $house->comments()->approved()->isRoot()->orderBy('created_at', 'desc')->paginate();

        return $this->success([
            'house' => $house,
            'comments' => $models
        ]);
    }

    public function articles($id)
    {
        $house = House::findOrFail($id);
        $articles = $house->articles()->orderBy('created_at', 'desc')->paginate();

        return $this->success([
            'house' => $house,
            'articles' => $articles
        ]);
    }

    public function comment($id, $comment_id)
    {
        $house = House::findOrFail($id);
        $model = Comment::find($comment_id);

        return $this->success($model);
    }

    public function submitComment($id)
    {
        $house = House::findOrFail($id);
        $comment = Comment::create([
            'content' => request('content'),
            'parent_id' => request('parent_id'),
        ]);
        $house->comments()->save($comment);

        return $this->success($comment);
    }

    public function favorite($id)
    {
        $house = House::findOrFail($id);
        $user = auth()->user();
        $user->houses()->attach($house);
        $house->increment('total_favor');

        return $this->success($house);
    }

    public function removeFavorite($id)
    {
        $house = House::findOrFail($id);
        $user = auth()->user();
        $user->houses()->detach($house);
        $house->decrement('total_favor');

        return $this->success($house);
    }

    public function subscribe($id)
    {
        $house = House::findOrFail($id);
        $user = auth()->user();
        $house->subscribers()->attach($user);

        return $this->success($house);
    }

    public function removeSubscribe($id)
    {
        $house = House::findOrFail($id);
        $user = auth()->user();
        $house->subscribers()->detach($user);

        return $this->success($house);
    }

    public function quickSearch()
    {
        $keyword = request('keyword');
        $builder = House::where('name', 'like', "%{$keyword}%")
            ->orWhere('id', 'like', "%{$keyword}%");
        $per_page = request('per_page') ?? 10;

        return $builder->paginate($per_page);
    }
}
