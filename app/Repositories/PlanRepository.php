<?php

namespace App\Repositories;

use App\Http\Requests\Plan as Requests;
use App\Models\Plan;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    public function getAllPlans(string $language)
    {
        $plans = Plan::all();

        $plansData = $plans->map(function ($plan) use ($language) {
            return [
                'id' => $plan->id,
                'title' => $plan->{"title_$language"},
                'duration' => $plan->duration,
                'price' => $plan->price,
                'description' => $plan->{"description_$language"},
                'restrictions' => $plan->{"restrictions_$language"},
            ];
        });

        return $plansData;
    }

    public function getPlanById(int $planId, string $language)
    {
        $plan = Plan::find($planId);

        if ($plan) {
            $planData = [
                'id' => $plan->id,
                'title' => $plan->{"title_$language"},
                'duration' => $plan->duration,
                'price' => $plan->price,
                'description' => $plan->{"description_$language"},
                'restrictions' => $plan->{"restrictions_$language"},
            ];

            return $planData;
        } else {
            throw new \Exception(__('errors.notFoundPlanError'), 404);
        }
    }

    public function createPlan(Requests\CreatePlanRequest $data)
    {
        return Plan::create([
            'title_en' => $data->title_en,
            'title_uk' => $data->title_uk,
            'duration' => $data->duration,
            'price' => $data->price,
            'description_uk' => $data->description_uk,
            'description_en' => $data->description_en,
            'restrictions_en' => $data->restrictions_en,
            'restrictions_uk' => $data->restrictions_uk,
        ]);
    }

    public function updatePlan(Requests\UpdatePlanRequest $data, int $planId)
    {
        $plan = Plan::find($planId);

        if ($plan) {
            $plan->update([
                'title_en' => $data->title_en ?? $plan->title_en,
                'title_uk' => $data->title_uk ?? $plan->title_uk,
                'duration' => $data->duration ?? $plan->duration,
                'price' => $data->price ?? $plan->price,
                'description_uk' => $data->description_uk ?? $plan->description_uk,
                'description_en' => $data->description_en ?? $plan->description_en,
                'restrictions_en' => $data->restrictions_en ?? $plan->restrictions_en,
                'restrictions_uk' => $data->restrictions_uk ?? $plan->restrictions_uk,
            ]);

            return Plan::find($planId);
        } else {
            throw new \Exception(__('errors.notFoundPlanError'), 404);
        }
    }

    public function deletePlan(int $planId)
    {
        $plan = Plan::find($planId);
        if ($plan) {
            return $plan->delete();
        } else {
            throw new \Exception(__('errors.notFoundPlanError'), 404);
        }
    }
}
