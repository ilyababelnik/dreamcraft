<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment as Request;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(protected CommentService $commentService)
    {
    }

    public function getRandomComments()
    {
        try {
            $result = $this->commentService->getRandomComments();

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

    public function createComment(Request\CommentCreateRequest $request)
    {
        try {
            $result = $this->commentService->createComment($request);

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

    public function updateComment(Request\CommentUpdateRequest $request, int $commentId)
    {
        try {
            $result = $this->commentService->updateComment($request, $commentId);

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

    public function deleteComment(int $commentId)
    {
        try {
            $this->commentService->deleteComment($commentId);

            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
