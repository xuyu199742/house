<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Comment;
use App\Models\House;
use App\Models\Tag;

/**
 * Class HouseController
 *
 * @package App\Http\Controllers\Api
 */
class CommentController extends ApiController
{
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        $house   = $comment->commentable;
        $replies = Comment::where('parent_id', $comment->id)->approved()->paginate();

        return $this->success([
            'comment'      => $comment,
            'house'        => $house,
            'replies'      => $replies,
        ]);
    }

    public function like($id)
    {
        $comment = Comment::find($id);
        $comment->action(null, true);
        return $comment;
    }

    public function cancelLike($id)
    {
        $comment = Comment::find($id);
        $comment->action(null, true, true);
        return $comment;
    }

    public function tread($id)
    {
        $comment = Comment::find($id);
        $comment->action(null, false);
        return $comment;
    }

    public function cancelTread($id)
    {
        $comment = Comment::find($id);
        $comment->action(null, false, true);
        return $comment;
    }
}
