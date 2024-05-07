<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Plan as Requests;

interface PlanRepositoryInterface
{
    public function getAllPlans(string $language);

    public function getPlanById(int $planId, string $language);

    public function createPlan(Requests\CreatePlanRequest $data);

    public function updatePlan(Requests\UpdatePlanRequest $data, int $markId);

    public function deletePlan(int $markId);
}
