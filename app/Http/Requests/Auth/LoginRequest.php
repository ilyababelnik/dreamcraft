<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => [
                'required',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:20',
            ],
        ];
    }
}
