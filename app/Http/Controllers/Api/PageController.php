<?php

namespace App\Http\Controllers\Api;

use App\Models\District;
use App\Models\Homeconfig;
use App\Models\HomeconfigCategory;
use App\Models\Hotsearch;
use App\Models\House;
use App\Models\Shortcut;
use App\Models\Sponsor;
use App\Models\Subway;
use App\Models\Tab;
use App\Models\Tracker;
use App\Models\Tracking;
use App\Models\Message;
use Carbon\Carbon;

/**
 * Class HouseController
 *
 * @package App\Http\Controllers\Api
 */
class PageController extends ApiController
{
    public function index()
    {
        $categories = HomeconfigCategory::all();
        $houses     = [];
        foreach ($categories as $category) {
            $houses[ $category->id ] = House::published()->select('houses.id as id', 'houses.*')->join('homeconfigs', function ($join) use ($category) {
                $join->on('homeconfigs.house_id', '=', 'houses.id')
                        ->where('homeconfigs.category', '=', $category->id);
            })->with('tags')->take(4)->get();
        }
        $data = [
            'houses'    => $houses,
            'shortcuts' => Shortcut::intime()->orderBy('order', 'desc')->take(10)->get()
        ];

        return $this->success($data);
    }

    public function init()
    {
        $sponsors_tapes = [];
        foreach (HomeconfigCategory::all() as $category) {
            $sponsors_tapes[ $category->id ] = Sponsor::intime()->where('position', Sponsor::POSITION_TAPES)->where('sub_position', $category->id)->get();
        }

        $data = [
            'tabs'                => Tab::intime()->get(),
            'default_search'      => config('settings.default_search'),
            'terms_and_condition' => config('settings.terms_and_condition'),
            'wechat_account'      => config('settings.wechat_account'),
            'home_categories'     => HomeconfigCategory::pluck('name', 'id')->toArray(),
            'sponsors'            => [
                'start'    => Sponsor::intime()->where('position', Sponsor::POSITION_START)->get(),
                'float'    => Sponsor::intime()->where('position', Sponsor::POSITION_FLOAT)->get(),
                'top'      => Sponsor::intime()->where('position', Sponsor::POSITION_TOP)->get(),
                'article'  => Sponsor::intime()->where('position', Sponsor::POSITION_ARTICLE)->get(),
                'search'   => Sponsor::intime()->where('position', Sponsor::POSITION_SEARCH)->get(),
                'question' => Sponsor::intime()->where('position', Sponsor::POSITION_QUESTION)->get(),
                'house_detail' => Sponsor::intime()->where('position', Sponsor::POSITION_HOUSE_DETAIL)->get(),
                'footer'   => [],
                'tapes'    => $sponsors_tapes
            ],
            'zones'               => District::toConfig(),
            'prices'              => [
                [
                    "id"       => 'amount',
                    "name"     => '总价',
                    'children' => [
                        [
                            "id"   => '0-50',
                            "name" => '50万以下',
                        ],
                        [
                            "id"   => '50-100',
                            "name" => '50-100万',
                        ],
                        [
                            "id"   => '100-150',
                            "name" => '100-150万',
                        ],
                        [
                            "id"   => '150-200',
                            "name" => '150-200万',
                        ],
                        [
                            "id"   => '200-250',
                            "name" => '200-250万',
                        ],
                        [
                            "id"   => '250-300',
                            "name" => '250-300万',
                        ],
                        [
                            "id"   => '300-9999999999',
                            "name" => '300万以上',
                        ],
                    ]
                ],
                [
                    "id"       => 'price',
                    "name"     => '单价',
                    'children' => [
                        [
                            "id"   => '0-6000',
                            "name" => '6000元/㎡以下',
                        ],
                        [
                            "id"   => '6000-8000',
                            "name" => '6000-8000元/㎡',
                        ],
                        [
                            "id"   => '8000-10000',
                            "name" => '8000-10000元/㎡',
                        ],
                        [
                            "id"   => '10000-15000',
                            "name" => '10000-15000元/㎡',
                        ],
                        [
                            "id"   => '15000-20000',
                            "name" => '15000-20000元/㎡',
                        ],
                        [
                            "id"   => '20000-30000',
                            "name" => '20000-30000元/㎡',
                        ],
                        [
                            "id"   => '30000-9999999999',
                            "name" => '30000元/㎡以上',
                        ],
                    ]
                ]
            ],
            'subways'             => Subway::toConfig(),
            'housetypes'          => [
                [
                    'id'   => '1',
                    'name' => '一室'
                ], [
                    'id'   => '2',
                    'name' => '两室'
                ], [
                    'id'   => '3',
                    'name' => '三室'
                ], [
                    'id'   => '4',
                    'name' => '四室'
                ], [
                    'id'   => '5',
                    'name' => '五室'
                ], [
                    'id'   => '>5',
                    'name' => '五室以上'
                ]
            ],
            'areas'               => [
                [
                    'id'   => '0-50',
                    'name' => '50㎡以下'
                ], [
                    'id'   => '50-70',
                    'name' => '50-70㎡'
                ], [
                    'id'   => '70-90',
                    'name' => '80-90㎡'
                ], [
                    'id'   => '90-110',
                    'name' => '90-110㎡'
                ], [
                    'id'   => '110-130',
                    'name' => '110-130㎡'
                ], [
                    'id'   => '130-150',
                    'name' => '130-150㎡'
                ], [
                    'id'   => '150-9999999',
                    'name' => '150㎡以上'
                ]
            ],
            'decorations'         => [
                [
                    'id'   => 'yes',
                    'name' => '精装'
                ], [
                    'id'   => 'no',
                    'name' => '毛坯'
                ]
            ],
            'hot_search'          => Hotsearch::intime()->get()
        ];

        return $this->success($data);
    }

    public function track()
    {
        Tracker::record();

        return 'ok';
    }

    public function profile()
    {
        if ($user = auth()->user()) {
            $user->profile_name = request('name');
            $user->profile_id   = request('id');
            $user->save();

            return $user;
        }

        return 'error';
    }

    public function qrcode()
    {
        $image = config('settings.public_account_image');

        return redirect(url($image));
    }

    public function message()
    {
        $user = auth()->user();
        if (!$user) {
            return [];
        }
        $models = Message::ofUser($user->id)->orderBy('created_at', 'desc')->paginate();
        Message::ofUser($user->id)->update([ 'read_at' => Carbon::now() ]);

        return $models;
    }

    public function deleteMessage($id)
    {
        $message = Message::find($id);
        $message->delete();

        return $message;
    }

    public function summary()
    {
        $unread = 0;
        if ($user = auth()->user()) {
            $unread = Message::ofUser($user->id)->unread()->count();
        }

        return response()->json([
            'unread' => $unread
        ]);
    }
}
