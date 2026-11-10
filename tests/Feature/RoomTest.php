<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_liste_affiche_les_salles(): void
    {
        Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        $this->get('/rooms')
            ->assertOk()
            ->assertSee('Salle A')
            ->assertSee('Bât. A')
            ->assertSee('20');
    }

    public function test_on_peut_creer_une_salle(): void
    {
        $this->post('/rooms', ['nom' => 'Salle B', 'batiment' => 'Bât. B', 'capacite' => 30])
            ->assertRedirect('/rooms/1');

        $this->assertDatabaseHas('rooms', ['nom' => 'Salle B', 'capacite' => 30]);
    }

    public function test_on_peut_modifier_une_salle(): void
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        $this->put('/rooms/'.$room->id, ['nom' => 'Salle A1', 'batiment' => 'Bât. C', 'capacite' => 25])
            ->assertRedirect('/rooms/'.$room->id);

        $this->assertDatabaseHas('rooms', ['id' => $room->id, 'nom' => 'Salle A1', 'capacite' => 25]);
    }

    public function test_on_peut_supprimer_une_salle_vide(): void
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        $this->delete('/rooms/'.$room->id)
            ->assertRedirect('/rooms')
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function test_une_salle_avec_du_materiel_ne_peut_pas_etre_supprimee(): void
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        Device::create([
            'nom' => 'PC-001',
            'marque' => 'Dell',
            'numero_serie' => 'SN-0001',
            'etat' => 'bon',
            'date_achat' => '2024-01-15',
            'room_id' => $room->id,
        ]);

        $this->delete('/rooms/'.$room->id)
            ->assertRedirect('/rooms/'.$room->id)
            ->assertSessionHas('error');

        $this->assertDatabaseHas('rooms', ['id' => $room->id]);
        $this->assertDatabaseHas('devices', ['nom' => 'PC-001']);
    }

    public function test_les_champs_obligatoires_sont_verifies(): void
    {
        $this->post('/rooms', [])
            ->assertSessionHasErrors(['nom', 'batiment', 'capacite']);

        $this->assertDatabaseCount('rooms', 0);
    }

    public function test_la_capacite_doit_etre_positive(): void
    {
        $this->post('/rooms', ['nom' => 'Salle B', 'batiment' => 'Bât. B', 'capacite' => 0])
            ->assertSessionHasErrors('capacite');
    }

    public function test_la_page_de_detail_liste_le_materiel(): void
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        Device::create([
            'nom' => 'PC-SALLE-A',
            'marque' => 'Dell',
            'numero_serie' => 'SN-0001',
            'etat' => 'neuf',
            'date_achat' => '2024-01-15',
            'room_id' => $room->id,
        ]);

        $this->get('/rooms/'.$room->id)
            ->assertOk()
            ->assertSee('Salle A')
            ->assertSee('PC-SALLE-A');
    }

    public function test_une_salle_vide_propose_un_bouton(): void
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        $this->get('/rooms/'.$room->id)
            ->assertSee('Salle vide')
            ->assertSee(route('devices.create'));
    }
}
