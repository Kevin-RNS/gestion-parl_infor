<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use App\Models\Intervention;
use App\Models\Room;

class DashboardController extends Controller
{
    /**
     * Tableau de bord : quelques chiffres sur le parc.
     */
    public function index()
    {
        return view('dashboard', [
            'total' => Device::count(),
            'enPanne' => Device::where('etat', 'en panne')->count(),
            'totalSalles' => Room::count(),
            'totalInterventions' => Intervention::count(),
            'salles' => Room::withCount('devices')->orderBy('nom')->get(),
            'interventions' => Intervention::with('device')
                ->orderByDesc('date')
                ->limit(8)
                ->get(),
        ]);
    }
}
