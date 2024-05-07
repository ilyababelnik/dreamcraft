<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangeMeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'nullable',
                'string',
                'min:2',
                'max:10',
            ],
            'last_name' => [
                'nullable',
                'string',
                'min:2',
                'max:10',
            ],
            'nickname' => [
                'nullable',
                'string',
                'min:2',
                'max:15',
            ],
            'avatar' => [
                'nullable',
                'url',
            ],
            'email' => [
                'nullable',
                'email',
                'min:10',
                'max:20',
            ],
            'password' => [
                'nullable',
                Password::min(6)->max(20)->letters()->mixedCase()->numbers(),
                'confirmed',
            ],
            'password_confirmation' => [
                'nullable',
                Password::min(6)->max(20)->letters()->mixedCase()->numbers(),
            ],
        ];
    }
}
