<?php

namespace App\Http\Requests;

use App\Models\Intervention;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InterventionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'type' => ['required', Rule::in(array_keys(Intervention::TYPES))],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'La date de l\'intervention est obligatoire.',
            'date.date' => 'La date de l\'intervention doit être une date valide.',
            'type.required' => 'Le type d\'intervention est obligatoire.',
            'type.in' => 'Le type d\'intervention sélectionné n\'est pas valide.',
            'commentaire.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        ];
    }

    public function attributes(): array
    {
        return [
            'date' => 'date',
            'type' => 'type d\'intervention',
            'commentaire' => 'commentaire',
        ];
    }
}
