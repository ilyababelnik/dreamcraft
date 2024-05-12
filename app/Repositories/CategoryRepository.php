<?php

namespace App\Repositories;

use App\Http\Requests\Category as Request;
use App\Models as Models;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories(string $search, string $sortByPopularity, string $sortByMark, bool $alphabet, string $language)
    {
        $totalUsersCount = Models\User::whereNotNull('category_id')->count();

        $categories = Models\Category::query()
            ->withAvg('marks', 'mark')
            ->where('categories.title', 'like', "%{$search}%")
            ->groupBy('categories.id')
            ->get();

        if ($totalUsersCount > 0) {
            foreach ($categories as $category) {
                $countOfUsers = $category->users()->count();
                $category->popularity = round($countOfUsers / $totalUsersCount * 100, 2);
            }
        }

        if ($sortByPopularity === 'asc') {
            $categories = $categories->sortBy('popularity')->values()->all();
        } elseif ($sortByMark === 'asc') {
            $categories = $categories->sortBy('marks_avg_mark')->values()->all();
        } elseif ($sortByMark === 'desc') {
            $categories = $categories->sortByDesc('marks_avg_mark')->values()->all();
        } elseif ($alphabet) {
            $categories = $categories->sortBy('title')->values()->all();
        } elseif ($sortByPopularity === 'desc') {
            $categories = $categories->sortByDesc('popularity')->values()->all();
        } 

        foreach ($categories as &$category) {
            $category = [
                'id' => $category->id,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
                'title' => $category->title,
                'description' => $category->{"description_$language"},
                'image' => $category->image,
                'marks_avg_mark' => round($category->marks_avg_mark, 2),
                'popularity' => $category->popularity,
            ];
        }

        return $categories;
    }

    public function getCategoryById(int $categoryId, string $sort, string $language)
    {
        $totalUsersCount = Models\User::whereNotNull('category_id')->count();
        
        if ($totalUsersCount < 1) $totalUsersCount = 1;
        $category = Models\Category::with(['comments' => function ($query) use ($sort) {
            $query->orderBy('created_at', $sort);
        }])
            ->withAvg('marks', 'mark')
            ->find($categoryId);

        if ($category) {
            $countOfUsers = $category->users()->count();
            $category->popularity = round($countOfUsers / $totalUsersCount * 100, 2);

            $category = [
                'id' => $category->id,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
                'title' => $category->title,
                'description' => $category->{"description_$language"},
                'image' => $category->image,
                'marks_avg_mark' => round($category->marks_avg_mark, 2),
                'popularity' => $category->popularity,
                'comments' => $category->comments,
            ];

            return $category;
        } else {
            throw new \Exception(__('errors.notFoundCategoryError'), 404);
        }
    }

    public function createCategory(Request\CategoryCreateRequest $data)
    {
        $existCategory = Models\Category::where('title', $data->title)->first();

        if ($existCategory) {
            throw new \Exception(__('errors.duplicateCategoryTitleError'), 400);
        }

        return Models\Category::create([
            'title' => $data->title,
            'description_en' => $data->description_en,
            'description_uk' => $data->description_uk,
            'image' => $data->image,
        ]);
    }

    public function updateCategory(Request\CategoryUpdateRequest $data, int $categoryId)
    {
        $category = Models\Category::find($categoryId);

        $existCategory = Models\Category::where('title', $data->title)->first();

        if (! $category) {
            throw new \Exception(__('errors.notFoundCategoryError'), 404);
        }
        if ($existCategory) {
            throw new \Exception(__('errors.duplicateCategoryTitleError'), 400);
        }

        $category->update([
            'title' => $data->title ?? $category->title,
            'description_en' => $data->description_en ?? $category->description_en,
            'description_uk' => $data->description_uk ?? $category->description_uk,
            'image' => $data->image ?? $category->image,
        ]);

        return Models\Category::find($categoryId);
    }

    public function deleteCategory(int $categoryId)
    {
        $category = Models\Category::find($categoryId);
        if ($category) {
            return $category->delete();
        } else {
            throw new \Exception(__('errors.notFoundCategoryError'), 404);
        }
    }
}
