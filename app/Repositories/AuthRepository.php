<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Http\Requests\Auth as Requests;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function registration(Requests\RegistrationRequest $data)
    {
        $isEmailExists = User::where('email', $data->email)
            ->exists();

        $isNicknameExists = User::where('nickname', $data->nickname)
            ->exists();

        if ($isEmailExists) {
            throw new \Exception(__('errors.isEmailExistsError'), 400);
        }
        if ($isNicknameExists) {
            throw new \Exception(__('errors.isNicknameExistsError'), 400);
        }

        $user = User::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'nickname' => $data->nickname,
            'email' => $data->email,
            'password' => $data->password,
            'email_verified_at' => now(),
        ]);

        if ($user->id === 1) {
            $user->role = Role::admin;
            $user->save();
        }

        $history = [];
        $history[] = [
            'greeting' => __('auth.greeting'),
            'added_at' => now()->format('d.m.Y'),
        ];

        $user->update([
            'history' => $history,
        ]);

        return $user->createToken('default')->plainTextToken;
    }

    public function login(Requests\LoginRequest $data)
    {
        $user = User::where(function ($query) use ($data) {
            $query->where('email', $data->login)
                ->orWhere('nickname', $data->login);
        })->first();

        if (! $user) {
            throw new \Exception(__('errors.userIsNotExistError'), 400);
        }
        if (! Hash::check($data->password, $user->password)) {
            throw new \Exception(__('errors.wrongPasswordError'), 400);
        }

        return $user->createToken('default')->plainTextToken;
    }

    public function logout(Request $data)
    {
        return $data->user()->currentAccessToken()->delete();
    }
}
