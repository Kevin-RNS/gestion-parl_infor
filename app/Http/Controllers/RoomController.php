<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Liste des salles et nombre d'équipements par salle.
     */
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
            ->with('success', 'Salle « '.$room->nom.' » créée avec succès.');
    }

    /**
     * Affiche une salle.
     */
    public function show(Room $room)
    {
        $room->loadCount('devices')->load('devices.room');

        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return redirect()
            ->route('rooms.show', $room)
            ->with('success', 'Salle « '.$room->nom.' » modifiée avec succès.');
    }

    public function destroy(Room $room)
    {
        // La suppression d'une salle supprimerait ses équipements (cascade) :
        // on bloque tant que du matériel y est rattaché.
        if ($room->devices()->exists()) {
            return redirect()
                ->route('rooms.show', $room)
                ->with('error', 'Impossible de supprimer cette salle : '.$room->devices()->count()
                    .' équipement(s) y sont rattachés. Déplacez-les d\'abord.');
        }

        $nom = $room->nom;
        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Salle « '.$nom.' » supprimée.');
    }

    /**
     * Page de confirmation avant suppression.
     */
    public function confirmDestroy(Room $room)
    {
        return view('confirm-delete', [
            'name' => $room->nom,
            'route' => route('rooms.destroy', $room),
            'back' => route('rooms.show', $room),
        ]);
    }
}
