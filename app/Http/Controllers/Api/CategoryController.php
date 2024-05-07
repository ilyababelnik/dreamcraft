<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category as Requests;
use App\Services\CategoryService;

/**
 * @OA\Get(
 *      path="/api/categories",
 *      summary="Get all categories",
 *      tags={"Category"},
 *
 *      @OA\Parameter(
 *         description="Search by category's title",
 *         in="query",
 *         name="search",
 *         required=false,
 *
 *         @OA\Schema(type="string"),
 *
 *         @OA\Examples(example="string", value="Happy", summary="Search value"),
 *      ),
 *
 *      @OA\Parameter(
 *         description="Sort categories by popularity",
 *         in="query",
 *         name="sort",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"asc", "desc"}),
 *
 *         @OA\Examples(example="asc", value="asc", summary="ASC"),
 *         @OA\Examples(example="desc", value="desc", summary="DESC"),
 *      ),
 * 
 *      @OA\Parameter(
 *         description="Sort categories by avr mark",
 *         in="query",
 *         name="mark-sort",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"asc", "desc"}),
 *
 *         @OA\Examples(example="asc", value="asc", summary="ASC"),
 *         @OA\Examples(example="desc", value="desc", summary="DESC"),
 *      ),
 * 
 *      @OA\Parameter(
 *         description="Sort by alphabet",
 *         in="query",
 *         name="alphabet",
 *         required=false,
 *
 *         @OA\Schema(type="boolean"),
 *
 *         @OA\Examples(example="Example", value="true", summary="Result"),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="OK",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="title", type="string", example="Category Name"),
 *                  @OA\Property(property="description", type="string", example="Category description"),
 *                  @OA\Property(property="image", type="string", example="Category Image Link"),
 *                  @OA\Property(property="marks_avg_mark", type="string", example="4.0000 | null"),
 *                  @OA\Property(property="popularity", type="float", example=27.27272727),
 *                  ),
 *              ),
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
 * @OA\Get(
 *      path="/api/categories/{id}",
 *      summary="Get category by id",
 *      tags={"Category"},
 *
 *      @OA\Parameter(
 *         description="Id of the category",
 *         in="path",
 *         name="id",
 *         required=true,
 *
 *         @OA\Schema(type="integer"),
 *
 *         @OA\Examples(example="int", value="1", summary="Integer value"),
 *      ),
 *
 *      @OA\Parameter(
 *         description="Method of sort comments in category",
 *         in="query",
 *         name="sort",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"asc", "desc"}),
 *
 *         @OA\Examples(example="asc", value="asc", summary="ASC"),
 *         @OA\Examples(example="desc", value="desc", summary="DESC"),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="OK",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="title", type="string", example="Category Name"),
 *                  @OA\Property(property="description", type="string", example="Category description"),
 *                  @OA\Property(property="image", type="string", example="Category Image Link"),
 *                  @OA\Property(property="marks_avg_mark", type="string", example="4.0000"),
 *                  @OA\Property(property="popularity", type="float", example=27.27272727),
 *                  @OA\Property(property="comments", type="array", @OA\Items(
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                      @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                      @OA\Property(property="text", type="string", example="Labore ad rerum eum quo quidem. Doloremque accusamus"),
 *                      @OA\Property(property="is_edit", type="string", example="0"),
 *                      @OA\Property(property="category_id", type="integer", example=1),
 *                      @OA\Property(property="user_id", type="integer", example=1),
 *                  )), 
 *                  ),
 *              ),
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
 *          response=500,
 *          description="Server side error",
 *
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "message": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 *
 *  @OA\Post(
 *      path="/api/categories",
 *      summary="Create category | Only admins",
 *      tags={"Category"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="description_en",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="description_uk",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                 ),
 *                 example={"title": "Category title", "description_en": "Category description in English", "description_uk": "Category description in Ukrainian", "image": "Link to the category image"}
 *             ),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Create category",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="updated_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="title", type="string", example="Category title"),
 *                  @OA\Property(property="description_en", type="string", example="Category description in English"),
 *                  @OA\Property(property="description_uk", type="string", example="Category description in Ukrainian"),
 *                  @OA\Property(property="image", type="string", example="Link to the category image"),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "Category with this title already exist"}, summary="Result"),
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
 *          response=422,
 *          description="Validation errors",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"message": "The title_en field must be a string.","errors": {"title_en": "The title_en field must be a string."}}, summary="Result"),
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
 *   @OA\Patch(
 *      path="/api/categories/{id}",
 *      summary="Update category by id | Only admins",
 *      tags={"Category"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the category",
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
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description_en",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description_uk",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string"
 *                 ),
 *                 example={"title": "New Category Title", "description_en":"New category description in English", "description_uk":"New category description in Ukrainian", "image":"New Link to category image"}
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="OK",
 *          @OA\JsonContent(
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="title", type="string", example="New category title"),
 *                  @OA\Property(property="description_en", type="string", example="New category description in English"),
 *                  @OA\Property(property="description_uk", type="string", example="New category description in Ukrainian"),
 *                  @OA\Property(property="image", type="string", example="New category link to image"),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="Duplicate title",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "data": "Category with this title already exist"}, summary="Result"),
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
 *          response=403,
 *          description="Forbidden",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "message": "You don't have enough permissions"}, summary="Result"),
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
 *          description="Validation error",
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
 * @OA\Delete(
 *      path="/api/categories/{id}",
 *      summary="Delete category by id | Only admins",
 *      tags={"Category"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the category",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         @OA\Examples(example="int", value="1", summary="Integer value"),
 *      ),
 *
 *      @OA\Response(
 *          response=204,
 *          description="Delete category",
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
 *          description="Category not found",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "data": "Category not found"}, summary="Result"),
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
 */

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
