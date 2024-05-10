<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_en' => [
                'required',
                'string',
                'min:3',
                'max:20',
            ],
            'title_uk' => [
                'required',
                'string',
                'min:5',
                'max:20',
            ],
            'duration' => [
                'required',
                'integer',
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'description_uk' => [
                'required',
                'string',
                'min: 5',
                'max:100',
            ],
            'description_en' => [
                'required',
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
