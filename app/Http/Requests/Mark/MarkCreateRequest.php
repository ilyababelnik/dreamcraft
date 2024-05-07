<?php

namespace App\Http\Requests\Mark;

use Illuminate\Foundation\Http\FormRequest;

class MarkCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
            ],
            'mark' => [
                'required',
                'integer',
            ],
        ];
    }
}
