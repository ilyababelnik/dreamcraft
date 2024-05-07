<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan as Requests;
use App\Services\PlanService;

/**
 * @OA\Get(
 *      path="/api/plans",
 *      summary="Get all plans",
 *      tags={"Plan"},
 *      security={{ "bearerAuth": {} }},
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
 *                  @OA\Property(property="title", type="string", example="Plan Name"),
 *                  @OA\Property(property="description", type="string", example="Plan description"),
 *                  @OA\Property(property="duration", type="integer", example=60),
 *                  @OA\Property(property="price", type="float", example=12.12),
 *                  @OA\Property(property="restrictions", type="string", example="Some restrictions | null"),
 *                  ),
 *              ),
 *          ),
 *      ),
 * 
 *       @OA\Response(
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
 *      path="/api/plans/{id}",
 *      summary="Get plan by id",
 *      tags={"Plan"},
 *
 *      @OA\Parameter(
 *         description="Id of the plan",
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
 *          response=200,
 *          description="OK",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="title", type="string", example="Plan Name"),
 *                  @OA\Property(property="description", type="string", example="Plan description"),
 *                  @OA\Property(property="duration", type="integer", example=60),
 *                  @OA\Property(property="price", type="float", example=12.12),
 *                  @OA\Property(property="restrictions", type="string", example="Some restrictions | null"),
 *                  ),
 *              ),
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
 *          response=404,
 *          description="Plan not found",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "data": "Plan not found"}, summary="Result"),
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
 * @OA\Post(
 *      path="/api/plans",
 *      summary="Create plan | Only admins",
 *      tags={"Plan"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title_en",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="title_uk",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="float",
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
 *                     property="duration",
 *                     type="integer",
 *                 ),
 *                 @OA\Property(
 *                     property="restrictions_en",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="restrictions_uk",
 *                     type="string",
 *                 ),
 *                 example={"title_en": "Plan title in English", "title_uk": "Plan title in Ukrainian", "price": 12.12, "description_en":"Description plan in English", "description_uk":"Plan description in Ukrainian", "duration": 60, "restrictions_uk":"Restrictions in Ukrainian", "restrictions_en":"Restrictions in English"}
 *             ),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Create Plan",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="updated_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="title_en", type="string", example="Plan title in English"),
 *                  @OA\Property(property="title_uk", type="string", example="Plan title in Ukrainian"),
 *                  @OA\Property(property="duration", type="integer", example=60),
 *                  @OA\Property(property="price", type="numeric", example=12.12),
 *                  @OA\Property(property="description_uk", type="string", example="Plan description in Ukrainian"),
 *                  @OA\Property(property="description_en", type="string", example="Plan description in English"),
 *                  @OA\Property(property="restrictions_uk", type="string", example="Plan restrictions in Ukrainian | null"),
 *                  @OA\Property(property="restrictions_en", type="string", example="Plan restrictions in English | null"),
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
 *      path="/api/plans/{id}",
 *      summary="Update plan by id | Only admins",
 *      tags={"Plan"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the plan",
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
 *                     property="title_en",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="title_uk",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="float",
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
 *                     property="duration",
 *                     type="integer",
 *                 ),
 *                 @OA\Property(
 *                     property="restrictions_en",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="restrictions_uk",
 *                     type="string",
 *                 ),
 *                 example={"title_en": "Plan title in English", "title_uk": "Plan title in Ukrainian", "price": 12.12, "description_en":"Description plan in English", "description_uk":"Plan description in Ukrainian", "duration": 60, "restrictions_uk":"Restrictions in Ukrainian", "restrictions_en":"Restrictions in English"}
 *             ),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="OK",
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="updated_at", type="data", example="2024-04-27T21:27:04.000000Z"),
 *                  @OA\Property(property="title_en", type="string", example="Plan title in English"),
 *                  @OA\Property(property="title_uk", type="string", example="Plan title in Ukrainian"),
 *                  @OA\Property(property="duration", type="integer", example=60),
 *                  @OA\Property(property="price", type="numeric", example=12.12),
 *                  @OA\Property(property="description_uk", type="string", example="Plan description in Ukrainian"),
 *                  @OA\Property(property="description_en", type="string", example="Plan description in English"),
 *                  @OA\Property(property="restrictions_uk", type="string", example="Plan restrictions in Ukrainian | null"),
 *                  @OA\Property(property="restrictions_en", type="string", example="Plan restrictions in English | null"),
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
 *          response=403,
 *          description="Forbidden",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "message": "You don't have enough permissions"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Plan not found",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "data": "Plan not found"}, summary="Result"),
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
 *      path="/api/plans/{id}",
 *      summary="Delete plan by id | Only admins",
 *      tags={"Plan"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the plan",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         @OA\Examples(example="int", value="1", summary="Integer value"),
 *      ),
 *
 *      @OA\Response(
 *          response=204,
 *          description="Delete plan",
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
 *          description="Plan not found",
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"success": false, "data": "Plan not found"}, summary="Result"),
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
class PlanController extends Controller
{
    public function __construct(protected PlanService $planService)
    {
    }

    public function getAllPlans()
    {
        try {
            $language = request()->header('Accept-Language') ?? 'en';
            $result = $this->planService->getAllPlans($language);

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

    public function getPlanById(int $planId)
    {
        try {
            $language = request()->header('Accept-Language') ?? 'en';
            $result = $this->planService->getPlanById($planId, $language);

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

    public function createPlan(Requests\CreatePlanRequest $request)
    {
        try {
            $result = $this->planService->createPlan($request);

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

    public function updatePlan(Requests\UpdatePlanRequest $request, int $planId)
    {
        try {
            $result = $this->planService->updatePlan($request, $planId);

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

    public function deletePlan(int $planId)
    {
        try {
            $this->planService->deletePlan($planId);

            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
