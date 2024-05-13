<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan as Requests;
use App\Services\PlanService;

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
