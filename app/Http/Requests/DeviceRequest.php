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
        // Sur modif si $this->device existe ignore son propre numseri
        $deviceId = $this->route('device')?->id;

        return [
            'nom' => ['required', 'string', 'min:2', 'max:100'],
            'marque' => ['required', 'string', 'min:2', 'max:100'],
            'numero_serie' => ['required', 'string', 'min:3', 'max:50',
                Rule::unique('devices', 'numero_serie')->ignore($deviceId),
            ],
            'etat' => ['required', Rule::in(['neuf', 'bon', 'en panne'])],
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
            'marque.required' => 'La marque est obligatoire.',
            'numero_serie.required' => 'Le numéro de série est obligatoire.',
            'numero_serie.unique' => 'Ce numéro de série existe déjà.',
            'etat.required' => 'L\'état est obligatoire.',
            'date_achat.required' => 'La date d\'achat est obligatoire.',
            'room_id.required' => 'Vous devez choisir une salle.',
        ];
    }
}