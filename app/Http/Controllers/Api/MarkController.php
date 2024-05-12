<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mark as Requests;
use App\Services\MarkService;

/**
 * @OA\Post(
 *      path="/api/marks",
 *      summary="Create mark",
 *      tags={"Mark"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="category_id",
 *                     type="integer",
 *                 ),
 *                 @OA\Property(
 *                     property="mark",
 *                     type="integer",
 *                 ),
 *                 example={"category_id": 1, "mark":5}
 *             ),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Create mark",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="updated_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="mark", type="integer", example=5),
 *                  @OA\Property(property="category_id", type="integer", example=1),
 *                  @OA\Property(property="user_id", type="integer", example=1),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="The range of evaluation has been breached | Duplicate mark",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Evaluation", value={"message": "You cannot give a rating lower than 1"}, summary="Evaluation"),
 *              @OA\Examples(example="Duplicate", value={"message": "You already rated this category"}, summary="Duplicate"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "Unauthenticated."}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Category not found",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "data": "Category not found"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation errors",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The mark field must be an integer.","errors": {"mark": "The mark field must be an integer."}}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Server side error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "message": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 *
 * @OA\Patch(
 *      path="/api/marks/{id}",
 *      summary="Update mark by id | Only admins",
 *      tags={"Mark"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the mark",
 *         in="path",
 *         name="id",
 *         required=true,
 *
 *         @OA\Schema(type="integer"),
 *
 *         @OA\Examples(example="int", value="1", summary="Integer value"),
 *      ),
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="mark",
 *                     type="integer"
 *                 ),
 *                 example={"mark": 4}
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="OK",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="mark", type="integer", example=4),
 *                  @OA\Property(property="user_id", type="integer", example=1),
 *                  @OA\Property(property="category_id", type="integer", example=1),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="The range of evaluation has been breached",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "You cannot give a rating lower than 1"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "Unauthenticated."}, summary="Result"),
 *          ),
 *      ),
 * 
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "message": "You don't have enough permissions"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Mark not found",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "data": "Mark not found"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The mark field must be an integer.","errors": {"mark": "The mark field must be an integer."}}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Server side error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "message": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 *
 * @OA\Delete(
 *      path="/api/marks/{id}",
 *      summary="Delete mark by id | Only admins",
 *      tags={"Mark"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the mark",
 *         in="path",
 *         name="id",
 *         required=true,
 *
 *         @OA\Schema(type="integer"),
 *
 *         @OA\Examples(example="int", value="1", summary="Integer value"),
 *      ),
 *
 *      @OA\Response(
 *          response=204,
 *          description="Delete mark",
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "Unauthenticated."}, summary="Result"),
 *          ),
 *      ),
 * 
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "message": "You don't have enough permissions"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Mark not found",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "data": "Comment not found"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Server side error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "message": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 */
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
