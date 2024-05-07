<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_en' => [
                'nullable',
                'string',
                'min:5',
                'max:20',
            ],
            'title_uk' => [
                'nullable',
                'string',
                'min:5',
                'max:20',
            ],
            'duration' => [
                'nullable',
                'integer',
            ],
            'price' => [
                'nullable',
                'numeric',
            ],
            'description_uk' => [
                'nullable',
                'string',
                'min: 5',
                'max:100',
            ],
            'description_en' => [
                'nullable',
                'string',
                'min: 5',
                'max:100',
            ],
            'restrictions_en' => [
                'nullable',
                'string',
                'min: 5',
                'max:100',
            ],
            'restrictions_uk' => [
                'nullable',
                'string',
                'min: 5',
                'max:100',
            ],
        ];
    }
}
