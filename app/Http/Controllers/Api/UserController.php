<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User as Requests;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *      path="/api/users/me",
 *      summary="Get info about me",
 *      tags={"User"},
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
 *                  @OA\Property(property="first_name", type="string", example="My First Name"),
 *                  @OA\Property(property="last_name", type="string", example="My Last Name"),
 *                  @OA\Property(property="nickname", type="string", example="My nickname"),
 *                  @OA\Property(property="email", type="string", example="myaddress@gmail.com"),
 *                  @OA\Property(property="email_verified_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="avatar", type="string", example="https://2img.net/u/3412/19/22/63/avatars/110530-94.png"),
 *                  @OA\Property(property="role", type="string", example="user"),
 *                  @OA\Property(property="ban", type="string", example="0"),
 *                  @OA\Property(property="reason_ban", type="string", example="null"),
 *                  @OA\Property(property="category_id", type="string", example="null"),
 *                  @OA\Property(property="history", type="array", @OA\Items(
 *                      @OA\Property(property="greeting", type="string", example="Welcome there, DreamCrafter! Glad to see you with us!"),
 *                      @OA\Property(property="added_at", type="date", example="07.05.2024"),
 *                      ),
 *                  ),
 *                  @OA\Property(property="plan_id", type="integer", example=1),
 *                  @OA\Property(property="start_plan", type="date", example="date | null"),
 *                  @OA\Property(property="duration_plan", type="string", example="date | null"),
 *                  ),
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
 *          response=500,
 *          description="Server side error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"error": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 *
 * @OA\Get(
 *      path="/api/users/{id}",
 *      summary="Get user by id",
 *      tags={"User"},
 *
 *      @OA\Parameter(
 *         description="Id of the user",
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
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="first_name", type="string", example="My First Name"),
 *                  @OA\Property(property="last_name", type="string", example="My Last Name"),
 *                  @OA\Property(property="nickname", type="string", example="My nickname"),
 *                  @OA\Property(property="email", type="string", example="myaddress@gmail.com"),
 *                  @OA\Property(property="email_verified_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="avatar", type="string", example="https://2img.net/u/3412/19/22/63/avatars/110530-94.png"),
 *                  @OA\Property(property="role", type="string", example="user"),
 *                  @OA\Property(property="ban", type="string", example="0"),
 *                  @OA\Property(property="reason_ban", type="string", example="null"),
 *                  @OA\Property(property="category_id", type="string", example="null"),
 *                  @OA\Property(property="history", type="array", @OA\Items(
 *                      @OA\Property(property="greeting", type="string", example="Welcome there, DreamCrafter! Glad to see you with us!"),
 *                      @OA\Property(property="added_at", type="date", example="07.05.2024"),
 *                      ),
 *                  ),
 *                  @OA\Property(property="plan_id", type="integer", example=1),
 *                  @OA\Property(property="start_plan", type="date", example="date | null"),
 *                  @OA\Property(property="duration_plan", type="string", example="date | null"),
 *                  ),
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
 *          description="User not found",
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
 *
 *              @OA\Examples(example="Result", value={"error": "Something wrong. Try later."}, summary="Result"),
 *          ),
 *      ),
 * ),
 * 
 * @OA\Patch(
 *      path="/api/users/change-me",
 *      summary="Update information about me",
 *      tags={"User"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the user",
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
 *                     property="first_name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="last_name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="nickname",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="avatar",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password_confirmation",
 *                     type="string"
 *                 ),
 *                 example={"first_name": "New First Name", "last_name": "New Last Name", "nickname": "New nickname", "avatar":"New link to avatar", "email": "New email", "password":"New password", "password_confirmation": "New password"}
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
 *              @OA\Property(property="data", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="first_name", type="string", example="My First Name"),
 *                  @OA\Property(property="last_name", type="string", example="My Last Name"),
 *                  @OA\Property(property="nickname", type="string", example="My nickname"),
 *                  @OA\Property(property="email", type="string", example="myaddress@gmail.com"),
 *                  @OA\Property(property="email_verified_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="avatar", type="string", example="https://2img.net/u/3412/19/22/63/avatars/110530-94.png"),
 *                  @OA\Property(property="role", type="string", example="user"),
 *                  @OA\Property(property="ban", type="string", example="0"),
 *                  @OA\Property(property="reason_ban", type="string", example="null"),
 *                  @OA\Property(property="category_id", type="string", example="null"),
 *                  @OA\Property(property="history", type="array", @OA\Items(
 *                      @OA\Property(property="greeting", type="string", example="Welcome there, DreamCrafter! Glad to see you with us!"),
 *                      @OA\Property(property="added_at", type="date", example="07.05.2024"),
 *                      ),
 *                  ),
 *                  @OA\Property(property="plan_id", type="integer", example=1),
 *                  @OA\Property(property="start_plan", type="date", example="date | null"),
 *                  @OA\Property(property="duration_plan", type="string", example="date | null"),
 *                  ),
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
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The nickname field must be a string.","errors": {"nickname": "The nickname field must be a string."}}, summary="Result"),
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
 *      path="/api/users/subscribe",
 *      summary="Subscribe me to category",
 *      tags={"User"},
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
 *                     type="integer"
 *                 ),
 *                 example={"category_id": 1}
 *             )
 *         )
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
 *                  @OA\Property(property="first_name", type="string", example="My First Name"),
 *                  @OA\Property(property="last_name", type="string", example="My Last Name"),
 *                  @OA\Property(property="nickname", type="string", example="My nickname"),
 *                  @OA\Property(property="email", type="string", example="myaddress@gmail.com"),
 *                  @OA\Property(property="email_verified_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="avatar", type="string", example="https://2img.net/u/3412/19/22/63/avatars/110530-94.png"),
 *                  @OA\Property(property="role", type="string", example="user"),
 *                  @OA\Property(property="ban", type="string", example="0"),
 *                  @OA\Property(property="reason_ban", type="string", example="null"),
 *                  @OA\Property(property="category_id", type="string", example="null"),
 *                  @OA\Property(property="history", type="array", @OA\Items(
 *                      @OA\Property(property="greeting", type="string", example="Welcome there, DreamCrafter! Glad to see you with us!"),
 *                      @OA\Property(property="added_at", type="date", example="07.05.2024"),
 *                      ),
 *                  ),
 *                  @OA\Property(property="plan_id", type="integer", example=1),
 *                  @OA\Property(property="start_plan", type="date", example="date | null"),
 *                  @OA\Property(property="duration_plan", type="string", example="date | null"),
 *                  ),
 *              ),
 *          ),
 *      ),
 * 
 *      @OA\Response(
 *          response=400,
 *          description="User without plan",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "message": "Firstly, you need choose plan"}, summary="Result"),
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
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The category id must be an integer.","errors": {"category_id": "The category id must be an integer"}}, summary="Result"),
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
 *      path="/api/users/choose-plan",
 *      summary="Subscribe me to plan",
 *      tags={"User"},
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
 *                     property="plan_id",
 *                     type="integer"
 *                 ),
 *                 example={"plan_id": 1}
 *             )
 *         )
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
 *                  @OA\Property(property="first_name", type="string", example="My First Name"),
 *                  @OA\Property(property="last_name", type="string", example="My Last Name"),
 *                  @OA\Property(property="nickname", type="string", example="My nickname"),
 *                  @OA\Property(property="email", type="string", example="myaddress@gmail.com"),
 *                  @OA\Property(property="email_verified_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="avatar", type="string", example="https://2img.net/u/3412/19/22/63/avatars/110530-94.png"),
 *                  @OA\Property(property="role", type="string", example="user"),
 *                  @OA\Property(property="ban", type="string", example="0"),
 *                  @OA\Property(property="reason_ban", type="string", example="null"),
 *                  @OA\Property(property="category_id", type="string", example="null"),
 *                  @OA\Property(property="history", type="array", @OA\Items(
 *                      @OA\Property(property="greeting", type="string", example="Welcome there, DreamCrafter! Glad to see you with us!"),
 *                      @OA\Property(property="added_at", type="date", example="07.05.2024"),
 *                      ),
 *                  ),
 *                  @OA\Property(property="plan_id", type="integer", example=1),
 *                  @OA\Property(property="start_plan", type="date", example="date | null"),
 *                  @OA\Property(property="duration_plan", type="string", example="date | null"),
 *                  ),
 *              ),
 *          ),
 *      ),
 * 
 *      @OA\Response(
 *          response=400,
 *          description="User already has plan",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "message": "You already subscribe to another plan"}, summary="Result"),
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
 *              @OA\Examples(example="Result", value={"success": false, "data": "Category not found"}, summary="Result"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The plan id must be an integer.","errors": {"plan_id": "The plan id must be an integer"}}, summary="Result"),
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
 *      path="/api/users/cancel-plan",
 *      summary="Cancel subscription to plan",
 *      tags={"User"},
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
 *                     property="plan_id",
 *                     type="integer"
 *                 ),
 *                 example={"plan_id": 1}
 *             )
 *         )
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
 *                  @OA\Property(property="first_name", type="string", example="My First Name"),
 *                  @OA\Property(property="last_name", type="string", example="My Last Name"),
 *                  @OA\Property(property="nickname", type="string", example="My nickname"),
 *                  @OA\Property(property="email", type="string", example="myaddress@gmail.com"),
 *                  @OA\Property(property="email_verified_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="avatar", type="string", example="https://2img.net/u/3412/19/22/63/avatars/110530-94.png"),
 *                  @OA\Property(property="role", type="string", example="user"),
 *                  @OA\Property(property="ban", type="string", example="0"),
 *                  @OA\Property(property="reason_ban", type="string", example="null"),
 *                  @OA\Property(property="category_id", type="string", example="null"),
 *                  @OA\Property(property="history", type="array", @OA\Items(
 *                      @OA\Property(property="greeting", type="string", example="Welcome there, DreamCrafter! Glad to see you with us!"),
 *                      @OA\Property(property="added_at", type="date", example="07.05.2024"),
 *                      ),
 *                  ),
 *                  @OA\Property(property="plan_id", type="integer", example=1),
 *                  @OA\Property(property="start_plan", type="date", example="date | null"),
 *                  @OA\Property(property="duration_plan", type="string", example="date | null"),
 *                  ),
 *              ),
 *          ),
 *      ),
 * 
 *      @OA\Response(
 *          response=400,
 *          description="User don't has plan",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "message": "Firstly, you need choose plan"}, summary="Result"),
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
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The plan id must be an integer.","errors": {"plan_id": "The plan id must be an integer"}}, summary="Result"),
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
 *      path="/api/users/{id}/role",
 *      summary="Change role of the user | Only admins",
 *      tags={"User"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *         description="Id of the user",
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
 *                  @OA\Property(property="created_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="first_name", type="string", example="My First Name"),
 *                  @OA\Property(property="last_name", type="string", example="My Last Name"),
 *                  @OA\Property(property="nickname", type="string", example="My nickname"),
 *                  @OA\Property(property="email", type="string", example="myaddress@gmail.com"),
 *                  @OA\Property(property="email_verified_at", type="date", example="2024-04-27T17:45:19.000000Z"),
 *                  @OA\Property(property="avatar", type="string", example="https://2img.net/u/3412/19/22/63/avatars/110530-94.png"),
 *                  @OA\Property(property="role", type="string", example="user"),
 *                  @OA\Property(property="ban", type="string", example="0"),
 *                  @OA\Property(property="reason_ban", type="string", example="null"),
 *                  @OA\Property(property="category_id", type="string", example="null"),
 *                  @OA\Property(property="history", type="array", @OA\Items(
 *                      @OA\Property(property="greeting", type="string", example="Welcome there, DreamCrafter! Glad to see you with us!"),
 *                      @OA\Property(property="added_at", type="date", example="07.05.2024"),
 *                      ),
 *                  ),
 *                  @OA\Property(property="plan_id", type="integer", example=1),
 *                  @OA\Property(property="start_plan", type="date", example="date | null"),
 *                  @OA\Property(property="duration_plan", type="string", example="date | null"),
 *                  ),
 *              ),
 *          ),
 *      ),
 * 
 *      @OA\Response(
 *          response=400,
 *          description="Invalid role",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"success": false, "message": "Invalid role"}, summary="Result"),
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
 */
class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function getCurrentUser(Request $request)
    {
        try {
            $result = $this->userService->getCurrentUser($request);

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

    public function getUserById(int $userId)
    {
        try {
            $result = $this->userService->getUserById($userId);

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

    public function changeMe(Requests\ChangeMeRequest $request)
    {
        try {
            $result = $this->userService->changeMe($request);

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

    public function myChooseCategory(Requests\CreateSubscriptionRequest $request)
    {
        try {
            $result = $this->userService->myChooseCategory($request);

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

    public function mySubscriptionToPlan(Requests\CreateSubscriptionToPlanRequest $request)
    {
        try {
            $language = request()->header('Accept-Language') ?? 'en';
            $result = $this->userService->mySubscriptionToPlan($request, $language);

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

    public function myUnSubscriptionToPlan(Request $request)
    {
        try {
            $result = $this->userService->myUnSubscriptionToPlan($request);

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

    public function changeUserRole(int $userId)
    {
        try {
            $result = $this->userService->changeUserRole($userId);

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
}
