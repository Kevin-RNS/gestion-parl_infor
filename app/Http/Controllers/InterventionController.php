<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InterventionRequest;
use App\Models\Device;

class InterventionController extends Controller
{
    // ajoute une intervention 
    public function store(InterventionRequest $request, Device $device)
    {
        $device->interventions()->create($request->validated());

        return redirect()
            ->route('devices.show', $device)
            ->with('success', 'Intervention ajoutée avec succès.');
    }
}