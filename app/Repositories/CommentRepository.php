<?php

namespace App\Repositories;

use App\Http\Requests\Comment as Request;
use App\Models as Models;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentRepositoryInterface
{
    public function getRandomComments()
    {
        $count = 3;
        $comments = Models\Comment::with(['user', 'category'])->get();

        if ($comments->count() <= $count) {
            return $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at,
                    'text' => $comment->text,
                    'is_edit' => $comment->is_edit,
                    'category_id' => $comment->category->id,
                    'category_title' => $comment->category->title,
                    'user_id' => $comment->user->id,
                    'nickname' => $comment->user->nickname,
                    'avatar' => $comment->user->avatar,
                ];
            });
        }

        $randomIndexes = collect(range(0, $comments->count() - 1))->shuffle()->take($count);

        $randomComments = $comments->filter(function ($comment, $index) use ($randomIndexes) {
            return $randomIndexes->contains($index);
        });

        return $randomComments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
                'text' => $comment->text,
                'is_edit' => $comment->is_edit,
                'category_id' => $comment->category->id,
                'category_title' => $comment->category->title,
                'user_id' => $comment->user->id,
                'nickname' => $comment->user->nickname,
                'avatar' => $comment->user->avatar,
            ];
        })->values()->toArray();
    }

    public function createComment(Request\CommentCreateRequest $data)
    {
        $currentUser = Auth::user();
        $category = Models\Category::find($data->category_id);

        if (! $category) {
            throw new \Exception(__('errors.notFoundCategoryError'), 404);
        }

        return Models\Comment::create([
            'category_id' => $category->id,
            'user_id' => $currentUser->id,
            'text' => $data->text,
        ]);
    }

    public function updateComment(Request\CommentUpdateRequest $data, int $commentId)
    {
        $comment = Models\Comment::find($commentId);
        if (! $comment) {
            throw new \Exception(__('errors.notFoundCommentError'), 404);
        }

        $comment->update([
            'text' => $data->text,
            'is_edit' => '1',
        ]);

        return Models\Comment::find($commentId);
    }

    public function deleteComment(int $commentId)
    {
        $comment = Models\Comment::find($commentId);
        if ($comment) {
            return $comment->delete();
        } else {
            throw new \Exception(__('errors.notFoundCommentError'), 404);
        }
    }
}
