<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Http\Requests\User as Requests;
use App\Models as Models;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface
{
    public function getCurrentUser(Request $data)
    {
        return $data->user();
    }

    public function getUserById(int $userId)
    {
        $user = Models\User::find($userId);
        if (! $user) {
            throw new \Exception(__('errors.notFoundUserError'), 404);
        } else {
            return $user;
        }
    }

    public function changeMe(Requests\ChangeMeRequest $data)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getCurrentUser($data);
        $user->update([
            'first_name' => $data->first_name ?? $user->first_name,
            'last_name' => $data->last_name ?? $user->last_name,
            'nickname' => $data->nickname ?? $user->nickname,
            'avatar' => $data->avatar ?? $user->avatar,
            'password' => $data->password ?? $user->password,
            'email' => $data->email ?? $user->email,
        ]);

        return $userRepository->getCurrentUser($data);
    }

    public function myChooseCategory(Requests\CreateSubscriptionRequest $data)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getCurrentUser($data);

        $planId = $user->plan_id;

        if ($planId) {
            $categoryId = $data->category_id;
            $category = Models\Category::find($categoryId);
            if (! $category) {
                throw new \Exception(__('errors.notFoundCategoryError'), 404);
            }

            if ($user->category_id === $categoryId) {
                $user->update(['category_id' => null]);

                return $userRepository->getCurrentUser($data);

            } else {
                $historyPlan = $user->history ?? [];
                $historyPlan[] = [
                    'category' => [
                        'title' => $category->title,
                    ],
                    'added_at' => now()->format('d.m.Y'),
                ];

                $user->update([
                    'category_id' => $categoryId,
                    'history' => $historyPlan,
                ]);

                return $userRepository->getCurrentUser($data);
            }
        } else {
            throw new \Exception(__('errors.noChoosePlanError'), 400);
        }
    }

    public function mySubscriptionToPlan(Requests\CreateSubscriptionToPlanRequest $data, string $language)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getCurrentUser($data);

        $planId = $data->plan_id;

        $plan = Models\Plan::find($planId);
        if (! $plan) {
            throw new \Exception(__('errors.notFoundPlanError'), 404);
        }

        if ($user->plan_id === null) {

            $expirationDate = now()->addMinutes($plan->duration);
            $historyPlan = $user->history ?? [];
            $historyPlan[] = [
                'plan' => [
                    'title' => $plan->{"title_$language"},
                    'description' => $plan->{"description_$language"},
                ],
                'added_at' => now()->format('d.m.Y'),
            ];

            $user->update([
                'plan_id' => $planId,
                'start_plan' => now(),
                'duration_plan' => $expirationDate,
                'history' => $historyPlan,
            ]);

            return $userRepository->getCurrentUser($data);
        } else {
            throw new \Exception(__('errors.planAlreadySubscribeError'), 400);
        }
    }

    public function myUnSubscriptionToPlan(Request $data)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getCurrentUser($data);

        if ($user->plan_id === null) {
            throw new \Exception(__('errors.noChoosePlanError'), 400);
        } else {
            $user->update([
                'plan_id' => null,
                'start_plan' => null,
                'duration_plan' => null,
            ]);

            return $userRepository->getCurrentUser($data);
        }
    }

    public function changeUserRole(int $userId)
    {
        $user = Models\User::find($userId);
        if (! $user) {
            throw new \Exception(__('errors.notFoundUserError'), 404);
        }

        if ($user->role === Role::user) {
            $newRole = Role::admin;
        } elseif ($user->role === Role::admin) {
            $newRole = Role::user;
        } else {
            throw new \Exception(__('errors.noCorrectUserRoleError'), 400);
        }

        $user->update(['role' => $newRole]);

        return Models\User::find($userId);
    }
}
