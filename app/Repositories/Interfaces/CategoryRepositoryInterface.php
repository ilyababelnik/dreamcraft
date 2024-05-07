<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Category as Request;

interface CategoryRepositoryInterface
{
    public function getAllCategories(string $search, string $sortByPopularity, string $sortByMark, bool $alphabet, string $language);

    public function getCategoryById(int $categoryId, string $sort, string $language);

    public function createCategory(Request\CategoryCreateRequest $data);

    public function updateCategory(Request\CategoryUpdateRequest $data, int $categoryId);

    public function deleteCategory(int $categoryId);
}
