<?php

namespace App\Services;

use App\Http\Requests\User as Requests;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function getCurrentUser(Request $data)
    {
        return $this->userRepository->getCurrentUser($data);
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function changeMe(Requests\ChangeMeRequest $data)
    {
        return $this->userRepository->changeMe($data);
    }

    public function myChooseCategory(Requests\CreateSubscriptionRequest $data)
    {
        return $this->userRepository->myChooseCategory($data);
    }

    public function mySubscriptionToPlan(Requests\CreateSubscriptionToPlanRequest $data, string $language)
    {
        return $this->userRepository->mySubscriptionToPlan($data, $language);
    }

    public function myUnSubscriptionToPlan(Request $data)
    {
        return $this->userRepository->myUnSubscriptionToPlan($data);
    }

    public function changeUserRole(int $id)
    {
        return $this->userRepository->changeUserRole($id);
    }
}
