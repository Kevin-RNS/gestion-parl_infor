<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => [
                'required', 'string', 'min:2', 'max:100',
                Rule::unique('categories', 'nom')->ignore($this->route('category')?->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.min' => 'Le nom de la catégorie doit contenir au moins 2 caractères.',
            'nom.max' => 'Le nom de la catégorie ne peut pas dépasser 100 caractères.',
            'nom.unique' => 'Une catégorie porte déjà ce nom.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom de la catégorie',
        ];
    }
}
