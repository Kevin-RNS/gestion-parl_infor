<?php

namespace App\Http\Requests;

// use Illuminate\Contracts\Validation\ValidationRule;
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
            'type' => ['required', Rule::in(['maintenance', 'panne', 'reparation'])],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
