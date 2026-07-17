<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    // liste des salles et nombre d'équipements par salle 
    public function index()
    {
        $rooms = Room::withCount('devices')->orderBy('nom')->get();

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(RoomRequest $request)
    {
        $room = Room::create($request->validated());

        return redirect()
            ->route('rooms.show', $room)
            ->with('success', 'Salle créée avec succès.');
    }

    // Affiche une salle
    public function show(Room $room)
    {
        $room->load('devices');

        return view('rooms.show', compact('room'));
    }
}