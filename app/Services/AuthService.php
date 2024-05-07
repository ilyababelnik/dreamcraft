<?php

namespace App\Services;

use App\Http\Requests\Auth as Requests;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {
    }

    public function registration(Requests\RegistrationRequest $data)
    {
        return $this->authRepository->registration($data);
    }

    public function login(Requests\LoginRequest $data)
    {
        return $this->authRepository->login($data);
    }

    public function logout(Request $data)
    {
        return $this->authRepository->logout($data);
    }
}
