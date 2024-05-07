<?php

namespace App\Services;

use App\Http\Requests\Plan as Requests;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class PlanService
{
    public function __construct(protected PlanRepositoryInterface $planRepository)
    {
    }

    public function getAllPlans(string $language)
    {
        return $this->planRepository->getAllPlans($language);
    }

    public function getPlanById(int $id, string $language)
    {
        return $this->planRepository->getPlanById($id, $language);
    }

    public function createPlan(Requests\CreatePlanRequest $data)
    {
        return $this->planRepository->createPlan($data);
    }

    public function updatePlan(Requests\UpdatePlanRequest $data, int $id)
    {
        return $this->planRepository->updatePlan($data, $id);
    }

    public function deletePlan(int $id)
    {
        return $this->planRepository->deletePlan($id);
    }
}
