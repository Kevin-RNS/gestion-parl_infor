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
}