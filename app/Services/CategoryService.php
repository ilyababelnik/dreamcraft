<?php

namespace App\Services;

use App\Http\Requests\Category as Request;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function getAllCategories(string $search, string $sortByPopularity, string $sortByMark, bool $alphabet, string $language)
    {
        return $this->categoryRepository->getAllCategories($search, $sortByPopularity, $sortByMark, $alphabet, $language);
    }

    public function getCategoryById(int $id, string $sort, string $language)
    {
        return $this->categoryRepository->getCategoryById($id, $sort, $language);
    }

    public function createCategory(Request\CategoryCreateRequest $data)
    {
        return $this->categoryRepository->createCategory($data);
    }

    public function updateCategory(Request\CategoryUpdateRequest $data, int $id)
    {
        return $this->categoryRepository->updateCategory($data, $id);
    }

    public function deleteCategory(int $id)
    {
        return $this->categoryRepository->deleteCategory($id);
    }
}
