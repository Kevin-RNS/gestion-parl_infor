<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_liste_affiche_les_categories(): void
    {
        Category::create(['nom' => 'Imprimante']);

        $this->get('/categories')->assertOk()->assertSee('Imprimante');
    }

    public function test_on_peut_creer_une_categorie(): void
    {
        $this->post('/categories', ['nom' => 'Projecteur'])
            ->assertRedirect('/categories/1');

        $this->assertDatabaseHas('categories', ['nom' => 'Projecteur']);
    }

    public function test_on_peut_modifier_une_categorie(): void
    {
        $category = Category::create(['nom' => 'Projecteur']);

        $this->put('/categories/'.$category->id, ['nom' => 'Vidéoprojecteur'])
            ->assertRedirect('/categories/'.$category->id);

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'nom' => 'Vidéoprojecteur']);
    }

    public function test_une_categorie_peut_etre_supprimee_sans_supprimer_son_materiel(): void
    {
        $category = Category::create(['nom' => 'Imprimante']);
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 10]);

        $device = Device::create([
            'nom' => 'PC-001',
            'marque' => 'Dell',
            'numero_serie' => 'SN-0001',
            'etat' => 'bon',
            'date_achat' => '2024-01-15',
            'room_id' => $room->id,
        ]);

        $device->categories()->attach($category);

        $this->delete('/categories/'.$category->id)
            ->assertRedirect('/categories')
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseHas('devices', ['id' => $device->id]);
    }

    public function test_le_nom_est_obligatoire(): void
    {
        $this->post('/categories', [])->assertSessionHasErrors('nom');

        $this->assertDatabaseCount('categories', 0);
    }

    public function test_le_nom_est_unique(): void
    {
        Category::create(['nom' => 'Imprimante']);

        $this->post('/categories', ['nom' => 'Imprimante'])->assertSessionHasErrors('nom');

        $this->assertDatabaseCount('categories', 1);
    }

    public function test_la_page_de_detail_liste_le_materiel(): void
    {
        $category = Category::create(['nom' => 'Imprimante']);
        $room = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 10]);

        $device = Device::create([
            'nom' => 'IMP-001',
            'marque' => 'HP',
            'numero_serie' => 'SN-9999',
            'etat' => 'bon',
            'date_achat' => '2024-01-15',
            'room_id' => $room->id,
        ]);

        $device->categories()->attach($category);

        $this->get('/categories/'.$category->id)
            ->assertOk()
            ->assertSee('Imprimante')
            ->assertSee('IMP-001');
    }
}
