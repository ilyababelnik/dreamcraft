<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category as Requests;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function getAllCategories(Requests\CategorySearchAndSortRequest $request)
    {
        try {
            $search = $request['search'] ?? '';
            $sortByPopularity = $request['sort'] ?? 'desc';
            $sortByMark = $request['mark-sort'] ?? '';
            $alphabet = $request->has('alphabet') ? true : false;
            $language = request()->header('Accept-Language') ?? 'en';

            $result = $this->categoryService->getAllCategories($search, $sortByPopularity, $sortByMark, $alphabet, $language);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function getCategoryById(Requests\CategorySearchAndSortRequest $request, int $categoryId)
    {
        try {
            $isSort = $request->sort ?? 'desc';
            $language = request()->header('Accept-Language') ?? 'en';
            $result = $this->categoryService->getCategoryById($categoryId, $isSort, $language);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function createCategory(Requests\CategoryCreateRequest $request)
    {
        try {
            $result = $this->categoryService->createCategory($request);

            return response()->json([
                'success' => true,
                'data' => $result,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function updateCategory(Requests\CategoryUpdateRequest $request, int $categoryId)
    {
        try {
            $result = $this->categoryService->updateCategory($request, $categoryId);

            return response()->json([
                'success' => true,
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function deleteCategory(int $categoryId)
    {
        try {
            $this->categoryService->deleteCategory($categoryId);

            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
