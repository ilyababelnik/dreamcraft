<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'min:2',
                'max:10',
            ],
            'last_name' => [
                'required',
                'string',
                'min:2',
                'max:10',
            ],
            'nickname' => [
                'required',
                'string',
                'min:2',
                'max:15',
            ],
            'email' => [
                'required',
                'email',
                'min:10',
                'max:20',
            ],
            'password' => [
                'required',
                Password::min(6)->max(20)->letters()->mixedCase()->numbers(),
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                Password::min(6)->max(20)->letters()->mixedCase()->numbers(),
            ],
        ];
    }
}
