<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:categories,title'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vul een categorienaam in.',
            'title.unique' => 'Deze categorie bestaat al.',
        ];
    }
}
