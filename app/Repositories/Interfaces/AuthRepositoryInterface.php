<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Auth as Requests;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function registration(Requests\RegistrationRequest $data);

    public function login(Requests\LoginRequest $data);

    public function logout(Request $data);
}
