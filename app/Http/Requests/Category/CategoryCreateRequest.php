<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:20',
            ],
            'description_en' => [
                'required',
                'string',
                'min: 10',
                'max: 500',
            ],
            'description_uk' => [
                'required',
                'string',
                'min: 10',
                'max: 500',
            ],
            'image' => [
                'required',
                'url',
            ],
        ];
    }
}
