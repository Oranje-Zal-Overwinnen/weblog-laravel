<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWeblogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_premium' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vul een titel in.',
            'text.required' => 'Vul een tekst in.',
            'image.image' => 'Upload een geldige afbeelding.',
            'image.mimes' => 'De afbeelding moet een jpg-, png- of webp-bestand zijn.',
            'image.max' => 'De afbeelding mag maximaal 2 MB zijn.',
        ];
    }
}
