<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Intervention;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_le_tableau_de_bord_est_la_page_d_accueil(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewIs('dashboard')
            ->assertSee('Tableau de bord');
    }

    public function test_le_tableau_de_bord_affiche_les_indicateurs(): void
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        Device::create([
            'nom' => 'PC-001', 'marque' => 'Dell', 'numero_serie' => 'SN-1',
            'etat' => 'en panne', 'date_achat' => '2024-01-15', 'room_id' => $room->id,
        ]);

        Device::create([
            'nom' => 'PC-002', 'marque' => 'HP', 'numero_serie' => 'SN-2',
            'etat' => 'neuf', 'date_achat' => '2024-01-15', 'room_id' => $room->id,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertViewHas('total', 2)
            ->assertViewHas('enPanne', 1)
            ->assertViewHas('totalSalles', 1)
            ->assertViewHas('totalInterventions', 0);
    }

    public function test_le_tableau_de_bord_affiche_les_dernieres_interventions(): void
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        $device = Device::create([
            'nom' => 'PC-001', 'marque' => 'Dell', 'numero_serie' => 'SN-1',
            'etat' => 'bon', 'date_achat' => '2024-01-15', 'room_id' => $room->id,
        ]);

        Intervention::create([
            'date' => '2025-02-03', 'type' => 'maintenance',
            'commentaire' => 'Nettoyage', 'device_id' => $device->id,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Nettoyage')
            ->assertViewHas('totalInterventions', 1);
    }

    public function test_le_tableau_de_bord_gere_un_parc_vide(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewHas('total', 0)
            ->assertSee('Aucune intervention enregistrée');
    }

    public function test_le_tableau_de_bord_lien_vers_les_creations(): void
    {
        $this->get('/')
            ->assertSee(route('devices.create'))
            ->assertSee(route('rooms.index'));
    }
}
