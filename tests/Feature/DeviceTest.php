<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Device;
use App\Models\Intervention;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    private function salle(): Room
    {
        return Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);
    }

    private function donnees(array $extra = []): array
    {
        return array_merge([
            'nom' => 'PC-001',
            'marque' => 'Dell',
            'numero_serie' => 'SN-0001',
            'etat' => 'bon',
            'date_achat' => '2024-01-15',
            'room_id' => $this->salle()->id,
            'description' => 'Poste de travail',
            'categories' => [],
        ], $extra);
    }

    public function test_la_liste_affiche_les_equipements(): void
    {
        Device::create($this->donnees());

        $this->get('/devices')
            ->assertOk()
            ->assertSee('PC-001')
            ->assertSee('Dell')
            ->assertSee('SN-0001')
            ->assertSee('Salle A');
    }

    public function test_on_peut_creer_un_equipement(): void
    {
        $categorie = Category::create(['nom' => 'Poste fixe']);

        $response = $this->post('/devices', $this->donnees(['categories' => [$categorie->id]]));

        $device = Device::first();

        $response->assertRedirect('/devices/'.$device->id);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('devices', ['nom' => 'PC-001', 'numero_serie' => 'SN-0001']);

        $this->assertSame([$categorie->id], $device->categories->pluck('id')->all());
    }

    public function test_on_peut_modifier_un_equipement(): void
    {
        $device = Device::create($this->donnees());

        $this->put('/devices/'.$device->id, [
            'nom' => 'PC-002',
            'marque' => 'HP',
            'numero_serie' => 'SN-0001',
            'etat' => 'en panne',
            'date_achat' => '2024-01-15',
            'room_id' => $device->room_id,
        ])->assertRedirect('/devices/'.$device->id);

        $this->assertDatabaseHas('devices', ['id' => $device->id, 'nom' => 'PC-002', 'etat' => 'en panne']);
    }

    public function test_on_peut_supprimer_un_equipement(): void
    {
        $device = Device::create($this->donnees());

        $this->delete('/devices/'.$device->id)
            ->assertRedirect('/devices')
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
    }

    public function test_supprimer_un_equipement_supprime_ses_interventions(): void
    {
        $device = Device::create($this->donnees());

        Intervention::create(['date' => '2025-01-01', 'type' => 'panne', 'device_id' => $device->id]);

        $this->delete('/devices/'.$device->id);

        $this->assertDatabaseMissing('interventions', ['device_id' => $device->id]);
    }

    public function test_la_recherche_filtre_par_nom(): void
    {
        Device::create($this->donnees(['nom' => 'PC-COMPIL', 'numero_serie' => 'A1']));
        Device::create($this->donnees(['nom' => 'Serveur-WEB', 'numero_serie' => 'A2']));

        $this->get('/devices?search=COMPIL')
            ->assertSee('PC-COMPIL')
            ->assertDontSee('Serveur-WEB');
    }

    public function test_la_recherche_filtre_par_marque(): void
    {
        Device::create($this->donnees(['nom' => 'Alpha', 'marque' => 'Dell', 'numero_serie' => 'B1']));
        Device::create($this->donnees(['nom' => 'Beta', 'marque' => 'Lenovo', 'numero_serie' => 'B2']));

        $this->get('/devices?search=Lenovo')
            ->assertSee('Beta')
            ->assertDontSee('Alpha');
    }

    public function test_la_recherche_filtre_par_numero_de_serie(): void
    {
        Device::create($this->donnees(['nom' => 'Alpha', 'numero_serie' => 'ZZ-9999']));
        Device::create($this->donnees(['nom' => 'Beta', 'numero_serie' => 'YY-1111']));

        $this->get('/devices?search=ZZ-9999')
            ->assertSee('Alpha')
            ->assertDontSee('Beta');
    }

    public function test_on_peut_filtrer_par_etat(): void
    {
        Device::create($this->donnees(['nom' => 'Panne-1', 'etat' => 'en panne', 'numero_serie' => 'C1']));
        Device::create($this->donnees(['nom' => 'Neuf-1', 'etat' => 'neuf', 'numero_serie' => 'C2']));

        $this->get('/devices?etat=en+panne')
            ->assertSee('Panne-1')
            ->assertDontSee('Neuf-1');
    }

    public function test_on_peut_filtrer_par_salle(): void
    {
        $salleA = $this->salle();
        $salleB = Room::create(['nom' => 'Salle B', 'batiment' => 'Bât. B', 'capacite' => 10]);

        Device::create($this->donnees(['nom' => 'Dans-A', 'numero_serie' => 'R1', 'room_id' => $salleA->id]));
        Device::create($this->donnees(['nom' => 'Dans-B', 'numero_serie' => 'R2', 'room_id' => $salleB->id]));

        $this->get('/devices?room_id='.$salleB->id)
            ->assertSee('Dans-B')
            ->assertDontSee('Dans-A');
    }

    public function test_la_liste_est_paginee(): void
    {
        Device::factory()->count(25)->create();

        $response = $this->get('/devices');

        $response->assertOk();
        $this->assertCount(10, $response->viewData('devices')->items());
    }

    public function test_les_champs_obligatoires_sont_verifies(): void
    {
        $this->post('/devices', [])
            ->assertSessionHasErrors(['nom', 'marque', 'numero_serie', 'etat', 'date_achat', 'room_id']);

        $this->assertDatabaseCount('devices', 0);
    }

    public function test_le_numero_de_serie_est_unique(): void
    {
        Device::create($this->donnees());

        $this->post('/devices', $this->donnees(['nom' => 'Autre']))
            ->assertSessionHasErrors('numero_serie');

        $this->assertDatabaseCount('devices', 1);
    }

    public function test_l_etat_doit_connu(): void
    {
        $this->post('/devices', $this->donnees(['etat' => 'casse']))
            ->assertSessionHasErrors('etat');
    }

    public function test_une_salle_inconnue_est_refusee(): void
    {
        $this->post('/devices', $this->donnees(['room_id' => 999]))
            ->assertSessionHasErrors('room_id');
    }

    public function test_une_categorie_inconnue_est_refusee(): void
    {
        $this->post('/devices', $this->donnees(['categories' => [999]]))
            ->assertSessionHasErrors('categories.0');
    }

    public function test_la_page_de_detail_affiche_l_historique(): void
    {
        $device = Device::create($this->donnees());

        Intervention::create([
            'date' => '2025-03-04',
            'type' => 'maintenance',
            'commentaire' => 'Nettoyage DustBuster',
            'device_id' => $device->id,
        ]);

        $this->get('/devices/'.$device->id)
            ->assertOk()
            ->assertSee('PC-001')
            ->assertSee('Nettoyage DustBuster')
            ->assertSee('Maintenance')
            ->assertSee('04/03/2025');
    }

    public function test_un_equipement_inconnu_renvoie_une_404(): void
    {
        $this->get('/devices/999')->assertNotFound();
    }
}
