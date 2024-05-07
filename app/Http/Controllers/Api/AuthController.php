<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth as Requests;
use App\Services\AuthService;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *      path="/api/auth/registration",
 *      summary="Registration",
 *      tags={"Auth"},
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
 *                 example={"first_name":"User first name", "last_name":"User last name", "nickname":"User nickname", "email": "useraddress@gmail.com", "password":"password123", "password_confirmation":"password123"}
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Success",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="token", type="string", example="6|6OVYnQz9AqmUmlI1AJRA5zN69WCfi9TRNh5Ud70cd81455a1"),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="Bad request | Duplicate email | Duplicate nickname",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Duplicate email", value={"success": false, "message": "User with email already exists"}, summary="Duplicate email"),
 *              @OA\Examples(example="Duplicate nickname", value={"success": false, "message": "User with this nickname already exist"}, summary="Duplicate nickname"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The password field confirmation does not match.","errors": {"password": "The password field confirmation does not match."}}, summary="Result"),
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
 * @OA\Post(
 *      path="/api/auth/login",
 *      summary="Login",
 *      tags={"Auth"},
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="email | nickname",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 ),
 *                 example={"email": "useraddress@gmail.com", "password":"password123"}
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Success",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="token", type="string", example="6|6OVYnQz9AqmUmlI1AJRA5zN69WCfi9TRNh5Ud70cd81455a1"),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="Bad request | Non correct password",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Wrong email", value={"success": false, "message": "User doesn`t exist"}, summary="Wrong email"),
 *              @OA\Examples(example="Wrong password", value={"success": false, "message": "Wrong password"}, summary="Wrong password"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Examples(example="Result", value={"message": "The email field is required.","errors": {"email": "The email field is required."}}, summary="Result"),
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
 *  * @OA\Post(
 *      path="/api/auth/logout",
 *      summary="Logout",
 *      tags={"Auth"},
 *      security={{ "bearerAuth": {} }},
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="message", type="string", example="You are logged out"),
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *
 *          @OA\JsonContent(
 *              @OA\Examples(example="Result", value={"message": "Unauthenticated"}, summary="Result"),
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
class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function register(Requests\RegistrationRequest $request)
    {
        try {
            $token = $this->authService->registration($request);

            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function login(Requests\LoginRequest $request)
    {
        try {
            $token = $this->authService->login($request);

            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);

            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'You are logged out',
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
