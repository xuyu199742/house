<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Comment;

/**
 * Class HouseController
 *
 * @package App\Http\Controllers\Api
 */
class ArticleController extends ApiController
{
    public function index()
    {
        $per_page = request('per_page') ?? 10;
        $models   = Article::orderBy('created_at', 'desc')->paginate($per_page);
        return $this->success($models);
    }

    public function show($id)
    {
        $model = Article::findOrFail($id);
        $model->makeVisible('content');
        return $this->success($model);
    }

    public function submitComment($id)
    {
        $article = Article::findOrFail($id);
        $comment = Comment::create([
            'content' => request('content'),
            'parent_id' => request('parent_id'),
        ]);
        $article->comments()->save($comment);
        return $this->success($comment);
    }
}
