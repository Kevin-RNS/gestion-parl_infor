<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Sur modif, ignore le numéro de série du.device que l'on est en train de modifier.
        $deviceId = $this->route('device')?->id;

        return [
            'nom' => ['required', 'string', 'min:2', 'max:100'],
            'marque' => ['required', 'string', 'min:2', 'max:100'],
            'numero_serie' => ['required', 'string', 'min:3', 'max:50',
                Rule::unique('devices', 'numero_serie')->ignore($deviceId),
            ],
            'etat' => ['required', Rule::in(array_keys(\App\Models\Device::ETATS))],
            'date_achat' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
            'room_id' => ['required', 'exists:rooms,id'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de l\'équipement est obligatoire.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 100 caractères.',
            'marque.required' => 'La marque est obligatoire.',
            'marque.min' => 'La marque doit contenir au moins 2 caractères.',
            'numero_serie.required' => 'Le numéro de série est obligatoire.',
            'numero_serie.min' => 'Le numéro de série doit contenir au moins 3 caractères.',
            'numero_serie.max' => 'Le numéro de série ne peut pas dépasser 50 caractères.',
            'numero_serie.unique' => 'Ce numéro de série est déjà attribué à un autre équipement.',
            'etat.required' => 'L\'état est obligatoire.',
            'etat.in' => 'L\'état sélectionné n\'est pas valide.',
            'date_achat.required' => 'La date d\'achat est obligatoire.',
            'date_achat.date' => 'La date d\'achat doit être une date valide.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
            'room_id.required' => 'Vous devez choisir une salle.',
            'room_id.exists' => 'La salle sélectionnée n\'existe pas.',
            'categories.array' => 'La liste des catégories est invalide.',
            'categories.*.exists' => 'Une des catégories sélectionnées n\'existe pas.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'marque' => 'marque',
            'numero_serie' => 'numéro de série',
            'etat' => 'état',
            'date_achat' => 'date d\'achat',
            'description' => 'description',
            'room_id' => 'salle',
        ];
    }
}
