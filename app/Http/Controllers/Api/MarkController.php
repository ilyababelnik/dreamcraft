<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mark as Requests;
use App\Services\MarkService;

class MarkController extends Controller
{
    public function __construct(protected MarkService $markService)
    {
    }

    public function existMark(int $categoryId)
    {
        try {
            $result = $this->markService->existMark($categoryId);

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

    public function createMark(Requests\MarkCreateRequest $request)
    {
        try {
            $result = $this->markService->createMark($request);

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

    public function updateMark(Requests\MarkUpdateRequest $request, int $markId)
    {
        try {
            $result = $this->markService->updateMark($request, $markId);

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

    public function deleteMark(int $markId)
    {
        try {
            $this->markService->deleteMark($markId);

            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
