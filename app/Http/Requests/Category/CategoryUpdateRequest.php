<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'nullable',
                'string',
                'min:3',
                'max:20',
            ],
            'description_en' => [
                'nullable',
                'string',
                'min: 10',
                'max: 200',
            ],
            'description_uk' => [
                'nullable',
                'string',
                'min: 10',
                'max: 200',
            ],
            'image' => [
                'nullable',
                'url',
            ],
        ];
    }
}
