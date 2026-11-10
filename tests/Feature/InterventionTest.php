<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Intervention;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterventionTest extends TestCase
{
    use RefreshDatabase;

    private function device(): Device
    {
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);

        return Device::create([
            'nom' => 'PC-001',
            'marque' => 'Dell',
            'numero_serie' => 'SN-0001',
            'etat' => 'en panne',
            'date_achat' => '2024-01-15',
            'room_id' => $room->id,
        ]);
    }

    public function test_on_peut_ajouter_une_intervention(): void
    {
        $device = $this->device();

        $this->post('/devices/'.$device->id.'/interventions', [
            'date' => '2025-04-12',
            'type' => 'reparation',
            'commentaire' => 'Remplacement de la carte mère',
        ])->assertRedirect('/devices/'.$device->id);

        $this->assertDatabaseHas('interventions', [
            'device_id' => $device->id,
            'type' => 'reparation',
            'commentaire' => 'Remplacement de la carte mère',
        ]);
    }

    public function test_le_commentaire_est_facultatif(): void
    {
        $device = $this->device();

        $this->post('/devices/'.$device->id.'/interventions', [
            'date' => '2025-04-12',
            'type' => 'maintenance',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('interventions', [
            'device_id' => $device->id,
            'commentaire' => null,
        ]);
    }

    public function test_la_date_et_le_type_sont_obligatoires(): void
    {
        $device = $this->device();

        $this->post('/devices/'.$device->id.'/interventions', [])
            ->assertSessionHasErrors(['date', 'type']);

        $this->assertDatabaseCount('interventions', 0);
    }

    public function test_le_type_doit_connu(): void
    {
        $device = $this->device();

        $this->post('/devices/'.$device->id.'/interventions', [
            'date' => '2025-04-12',
            'type' => 'inconnu',
        ])->assertSessionHasErrors('type');
    }

    public function test_les_interventions_sont_triees_de_la_plus_recente_a_la_plus_ancienne(): void
    {
        $device = $this->device();

        Intervention::create(['date' => '2024-01-01', 'type' => 'maintenance', 'device_id' => $device->id]);
        Intervention::create(['date' => '2025-06-01', 'type' => 'panne', 'device_id' => $device->id]);

        $contenu = $this->get('/devices/'.$device->id)->getContent();

        $this->assertLessThan(
            strpos($contenu, '01/01/2024'),
            strpos($contenu, '01/06/2025')
        );
    }

    public function test_le_type_est_affiche_accentue(): void
    {
        $device = $this->device();

        Intervention::create(['date' => '2025-01-01', 'type' => 'reparation', 'device_id' => $device->id]);

        $this->get('/devices/'.$device->id)
            ->assertSee('Réparation')
            ->assertDontSee('>Reparation<');
    }
}
