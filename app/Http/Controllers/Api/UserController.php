<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User as Requests;
use App\Services\UserService;
use Illuminate\Http\Request;

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
