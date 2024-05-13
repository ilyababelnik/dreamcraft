<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth as Requests;
use App\Services\AuthService;
use Illuminate\Http\Request;

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
