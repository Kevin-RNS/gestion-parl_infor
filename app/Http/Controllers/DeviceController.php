<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeviceRequest;
use App\Models\Category;
use App\Models\Device;
use App\Models\Room;
class DeviceController extends Controller
{
    // Liste des équipements + recherche  + pagination 
    public function index(Request $request)
    {
        $query = Device::with('room', 'categories');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('marque', 'like', "%{$search}%");
            });
        }

        $devices = $query->orderBy('nom')->paginate(8)->withQueryString();

        return view('devices.index', compact('devices', 'search'));
    }

    public function create()
    {
        $rooms = Room::orderBy('nom')->get();
        $categories = Category::orderBy('nom')->get();

        return view('devices.create', compact('rooms', 'categories'));
    }

    public function store(DeviceRequest $request)
    {
        $device = Device::create($request->validated());

        // Association des catégories cochées 
        $device->categories()->sync($request->input('categories', []));

        return redirect()
            ->route('devices.show', $device)
            ->with('success', 'Équipement créé avec succès.');
    }

    public function show(Device $device)
    {
        $device->load('room', 'categories', 'interventions');

        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        $rooms = Room::orderBy('nom')->get();
        $categories = Category::orderBy('nom')->get();
        $device->load('categories');

        return view('devices.edit', compact('device', 'rooms', 'categories'));
    }

    public function update(DeviceRequest $request, Device $device)
    {
        $device->update($request->validated());
        $device->categories()->sync($request->input('categories', []));

        return redirect()
            ->route('devices.show', $device)
            ->with('success', 'Équipement modifié avec succès.');
    }

    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()
            ->route('devices.index')
            ->with('success', 'Équipement supprimé avec succès.');
    }
}