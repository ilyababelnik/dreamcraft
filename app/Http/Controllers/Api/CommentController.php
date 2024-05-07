<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment as Request;
use App\Services\CommentService;

/**
 * 
 * @OA\Get(
 *      path="/api/comments",
 *      summary="Get random comments",
 *      tags={"Comment"},
 *
 *      @OA\Response(
 *          response=200,
 *          description="OK",
 *          @OA\JsonContent(
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="text", type="string", example="Placeat vitae deserunt ullam voluptatem sit."),
 *                  @OA\Property(property="is_edit", type="string", example="0"),
 *                  @OA\Property(property="category_id", type="integer", example=1),
 *                  @OA\Property(property="category_title", type="string", example="aut"),
 *                  @OA\Property(property="user_id", type="integer", example=1),
 *                  @OA\Property(property="nickname", type="string", example="mellie79"),
 *                  @OA\Property(property="avatar", type="string", example="https://i.servimg.com/u/f21/18/21/41/30/na1110.png"),
 *                  ),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Server side error",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "message": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 * 
 * @OA\Post(
 *      path="/api/comments",
 *      summary="Create comment",
 *      tags={"Comment"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="category_id",
 *                     type="integer",
 *                 ),
 *                 @OA\Property(
 *                     property="text",
 *                     type="string",
 *                 ),
 *                 example={"category_id": 1, "text":"Text of comment"}
 *             ),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Create comment",
 *
 *          @OA\JsonContent(
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="updated_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="text", type="string", example="Text of comment"),
 *                  @OA\Property(property="category_id", type="integer", example=1),
 *                  @OA\Property(property="user_id", type="integer", example=1),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"message": "Unauthenticated."}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Category not found",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "data": "Category not found"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation errors",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"message": "The title field must be a string.","errors": {"title": "The title field must be a string."}}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Server side error",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "message": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 *
 * @OA\Patch(
 *      path="/api/comments/{id}",
 *      summary="Update comment by id | Only admins",
 *      tags={"Comment"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the comment",
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
 *                     property="text",
 *                     type="string"
 *                 ),
 *                 example={"text": "New Comment Text"}
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
 *                  @OA\Property(property="text", type="string", example="New Comment Text"),
 *                  @OA\Property(property="is_edit", type="string", example="1"),
 *                  @OA\Property(property="user_id", type="integer", example=1),
 *                  @OA\Property(property="category_id", type="integer", example=1),
 *              ),
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
 *          description="Comment not found",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "data": "Comment not found"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The text field must be a string.","errors": {"text": "The text field must be a string."}}, summary="Result"),
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
 *      path="/api/comments/{id}",
 *      summary="Delete comment by id | Only admins",
 *      tags={"Comment"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the comment",
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
 *          description="Delete comment",
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
 *          description="Comment not found",
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
