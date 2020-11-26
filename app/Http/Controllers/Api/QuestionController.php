<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\QuestionRequest;
use App\Models\Question;

/**
 * Class HouseController
 *
 * @package App\Http\Controllers\Api
 */
class QuestionController extends ApiController
{
    public function index()
    {
        $per_page = request('per_page') ?? 10;
        $builder = Question::where('id', '>', 0);

        if (request('hot')) {
            $builder->where('hot', true);
        }
        $models = $builder->orderBy('created_at', 'desc')->paginate($per_page);
        return $this->success($models);
    }

    public function show($id)
    {
        $model = Question::findOrFail($id);
        return $this->success($model);
    }

    public function mine()
    {
        $user = auth('api')->user();
        if (!$user) {
            return $this->fail();
        }
        $models = Question::ofUser($user)->orderBy('created_at', 'desc')->paginate();
        return $this->success($models);
    }

    public function store(QuestionRequest $request)
    {
        $user = auth('api')->user();
        $model = Question::create([
            'content' => request('content'),
            'user_id' => $user->id,
            'user_avatar' => $user->avatar,
            'user_name' => $user->name
        ]);
        return $this->success($model);
    }
}
