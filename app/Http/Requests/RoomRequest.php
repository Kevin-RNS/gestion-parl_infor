<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'min:2', 'max:100'],
            'batiment' => ['required', 'string', 'min:1', 'max:100'],
            'capacite' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la salle est obligatoire.',
            'nom.min' => 'Le nom de la salle doit contenir au moins 2 caractères.',
            'nom.max' => 'Le nom de la salle ne peut pas dépasser 100 caractères.',
            'batiment.required' => 'Le bâtiment est obligatoire.',
            'batiment.max' => 'Le bâtiment ne peut pas dépasser 100 caractères.',
            'capacite.required' => 'La capacité est obligatoire.',
            'capacite.integer' => 'La capacité doit être un nombre entier.',
            'capacite.min' => 'La capacité doit être d\'au moins 1.',
            'capacite.max' => 'La capacité ne peut pas dépasser 1000.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom de la salle',
            'batiment' => 'bâtiment',
            'capacite' => 'capacité',
        ];
    }
}
