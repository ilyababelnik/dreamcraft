<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\User as Requests;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getCurrentUser(Request $request);

    public function getUserById(int $id);

    public function changeMe(Requests\ChangeMeRequest $data);

    public function myChooseCategory(Requests\CreateSubscriptionRequest $data);

    public function mySubscriptionToPlan(Requests\CreateSubscriptionToPlanRequest $data, string $language);

    public function myUnSubscriptionToPlan(Request $data);

    public function changeUserRole(int $id);
}
