<?php

namespace App\Http\Requests\Mark;

use Illuminate\Foundation\Http\FormRequest;

class MarkUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mark' => [
                'required',
                'integer',
            ],
        ];
    }
}
