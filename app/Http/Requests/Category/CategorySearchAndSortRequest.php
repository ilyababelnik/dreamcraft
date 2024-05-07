<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorySearchAndSortRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'min: 4', 'max: 20'],
            'sort' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'mark-sort' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'alphabet' => ['nullable', 'boolean'],
        ];
    }
}
