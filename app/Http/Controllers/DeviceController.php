<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Category;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Liste des équipements : recherche, filtres et pagination.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $etat = $request->input('etat');
        $roomId = $request->input('room_id');

        $query = Device::with('room', 'categories');

        if ($search !== '') {
            $like = '%'.str_replace(['%', '_'], ['\%', '\_'], $search).'%';

            $query->where(function ($q) use ($like) {
                $q->where('nom', 'like', $like)
                    ->orWhere('marque', 'like', $like)
                    ->orWhere('numero_serie', 'like', $like);
            });
        }

        if ($etat) {
            $query->where('etat', $etat);
        }

        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        $devices = $query->orderBy('nom')->paginate(10)->withQueryString();

        return view('devices.index', [
            'devices' => $devices,
            'search' => $search,
            'etat' => $etat,
            'roomId' => $roomId,
            'rooms' => Room::orderBy('nom')->get(['id', 'nom']),
        ]);
    }

    public function create()
    {
        return view('devices.create', [
            'rooms' => Room::orderBy('nom')->get(),
            'categories' => Category::orderBy('nom')->get(),
        ]);
    }

    public function store(DeviceRequest $request)
    {
        $device = Device::create($request->validated());

        // On enregistre les catégories cochées.
        $device->categories()->sync($request->input('categories', []));

        return redirect()
            ->route('devices.show', $device)
            ->with('success', 'Équipement « '.$device->nom.' » créé avec succès.');
    }

    public function show(Device $device)
    {
        $device->load('room', 'categories', 'interventions');

        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        return view('devices.edit', [
            'device' => $device->load('categories'),
            'rooms' => Room::orderBy('nom')->get(),
            'categories' => Category::orderBy('nom')->get(),
        ]);
    }

    public function update(DeviceRequest $request, Device $device)
    {
        $device->update($request->validated());
        $device->categories()->sync($request->input('categories', []));

        return redirect()
            ->route('devices.show', $device)
            ->with('success', 'Équipement « '.$device->nom.' » modifié avec succès.');
    }

    /**
     * Page de confirmation avant suppression.
     */
    public function confirmDestroy(Device $device)
    {
        return view('confirm-delete', [
            'name' => $device->nom,
            'route' => route('devices.destroy', $device),
            'back' => route('devices.show', $device),
        ]);
    }

    public function destroy(Device $device)
    {
        $nom = $device->nom;
        $device->delete();

        return redirect()
            ->route('devices.index')
            ->with('success', 'Équipement « '.$nom.' » supprimé.');
    }
}
