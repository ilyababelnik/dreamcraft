<?php

namespace App\Repositories;

use App\Http\Requests\Mark as Request;
use App\Models as Models;
use App\Repositories\Interfaces\MarkRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class MarkRepository implements MarkRepositoryInterface
{
    public function existMark(int $categoryId)
    {
        $currentUser = Auth::user();

        $category = Models\Category::find($categoryId);
        if (! $category) {
            throw new \Exception(__('errors.notFoundCategoryError'), 404);
        }

        $existMark = Models\Mark::where('user_id', $currentUser->id)
            ->where('category_id', $categoryId)
            ->exists();

        if ($existMark) {
            return true;
        }

        return false;
    }

    public function createMark(Request\MarkCreateRequest $data)
    {
        $currentUser = Auth::user();
        $category = Models\Category::find($data->category_id);

        if (! $category) {
            throw new \Exception(__('errors.notFoundCategoryError'), 404);
        }

        $mark = $data->mark;
        if ($mark < 1) {
            throw new \Exception(__('errors.markLowerLimitError'), 400);
        }
        if ($mark > 5) {
            throw new \Exception(__('errors.markHigherLimitError'), 400);
        }

        $existMark = Models\Mark::where('user_id', $currentUser->id)
            ->where('category_id', $category->id)
            ->exists();

        if ($existMark) {
            throw new \Exception(__('errors.categoryAlreadyEvaluatedError'), 400);
        }

        $newMark = new Models\Mark();
        $newMark->user_id = $currentUser->id;
        $newMark->category_id = $category->id;
        $newMark->mark = $mark;
        $newMark->save();

        return $newMark;
    }

    public function updateMark(Request\MarkUpdateRequest $data, int $markId)
    {
        $markEntity = Models\Mark::find($markId);
        if (! $markEntity) {
            throw new \Exception(__('errors.notFoundMarkError'), 404);
        }

        $mark = $data->mark;
        if ($mark < 1) {
            throw new \Exception(__('errors.markLowerLimitError'), 400);
        }
        if ($mark > 5) {
            throw new \Exception(__('errors.markHigherLimitError'), 400);
        }

        $markEntity->update([
            'mark' => $mark,
        ]);

        return Models\Mark::find($markId);
    }

    public function deleteMark(int $markId)
    {
        $mark = Models\Mark::find($markId);
        if ($mark) {
            return $mark->delete();
        } else {
            throw new \Exception(__('errors.notFoundMarkError'), 404);
        }
    }
}
