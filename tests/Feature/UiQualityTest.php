<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Vérifie quelques points de qualité d'interface (accessibilité, pagination,
 * affichage). Ce sont des tests simples sur le HTML renvoyé.
 */
class UiQualityTest extends TestCase
{
    use RefreshDatabase;

    private function creerDonnees(): void
    {
        $salle = Room::create(['nom' => 'Salle A', 'batiment' => 'Bât. A', 'capacite' => 20]);
        $categorie = Category::create(['nom' => 'Poste fixe']);

        $device = Device::create([
            'nom' => 'PC-001',
            'marque' => 'Dell',
            'numero_serie' => 'SN-0001',
            'etat' => 'en panne',
            'date_achat' => '2024-01-15',
            'room_id' => $salle->id,
        ]);

        $device->categories()->attach($categorie);
    }

    /** @return array<string, array{0: string}> */
    public static function pages(): array
    {
        return [
            'tableau de bord' => ['/'],
            'liste des équipements' => ['/devices'],
            'création d\'un équipement' => ['/devices/create'],
            'salles' => ['/rooms'],
            'création d\'une salle' => ['/rooms/create'],
            'catégories' => ['/categories'],
            'création d\'une catégorie' => ['/categories/create'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('pages')]
    public function test_chaque_page_a_un_titre_et_un_contenu_principal(string $url): void
    {
        $this->creerDonnees();

        $response = $this->get($url);

        $response->assertOk();
        $response->assertSee('<title>', false);
        $response->assertSee('id="main-content"', false);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('pages')]
    public function test_chaque_page_a_un_lien_pour_aller_au_contenu(string $url): void
    {
        $this->creerDonnees();

        $this->get($url)
            ->assertSee('href="#main-content"', false)
            ->assertSee('Aller au contenu principal');
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('pages')]
    public function test_les_champs_de_formulaire_ont_un_libelle(string $url): void
    {
        $this->creerDonnees();

        $contenu = $this->get($url)->getContent();

        // Chaque champ doit avoir un id, et chaque id un label associé.
        preg_match_all('/<(input|select|textarea)[^>]*\bid="([^"]+)"/', $contenu, $champs);

        foreach ($champs[2] as $id) {
            $this->assertStringContainsString(
                'for="'.$id.'"',
                $contenu,
                'Le champ '.$id.' n\'a pas de libellé associé.'
            );
        }
    }

    public function test_les_boutons_icone_ont_un_nom_lisible(): void
    {
        $this->creerDonnees();

        $contenu = $this->get('/devices')->getContent();

        preg_match_all('/<a[^>]*class="icon-btn[^"]*"[^>]*>/', $contenu, $boutons);

        $this->assertNotEmpty($boutons[0]);

        foreach ($boutons[0] as $bouton) {
            $this->assertMatchesRegularExpression(
                '/aria-label="[^"]+"/',
                $bouton,
                'Un bouton icône n\'a pas de aria-label : '.$bouton
            );
        }
    }

    public function test_la_pagination_affiche_des_fleches_et_des_libelles_francais(): void
    {
        $this->creerDonnees();
        Device::factory()->count(25)->create();

        $contenu = $this->get('/devices?page=2')->getContent();

        $this->assertStringContainsString('bi-chevron-left', $contenu);
        $this->assertStringContainsString('bi-chevron-right', $contenu);
        $this->assertStringContainsString('Précédent', $contenu);
        $this->assertStringContainsString('Suivant', $contenu);

        // Les clés de traduction ne doivent jamais être affichées telles quelles.
        $this->assertStringNotContainsString('pagination.previous', $contenu);
        $this->assertStringNotContainsString('pagination.next', $contenu);
    }

    public function test_la_pagination_conserve_la_recherche_en_cours(): void
    {
        $this->creerDonnees();

        // 15 équipements nommés pareil : on obtient plusieurs pages.
        for ($i = 1; $i <= 15; $i++) {
            Device::create([
                'nom' => 'PC-TEST-'.$i,
                'marque' => 'Dell',
                'numero_serie' => 'TEST-'.$i,
                'etat' => 'bon',
                'date_achat' => '2024-01-15',
                'room_id' => Room::first()->id,
            ]);
        }

        $contenu = $this->get('/devices?search=PC-TEST')->getContent();

        $this->assertStringContainsString('search=PC-TEST', $contenu);
    }

    public function test_les_tableaux_sont_defilables_sur_mobile(): void
    {
        $this->creerDonnees();

        $this->get('/devices')->assertSee('table-wrap', false);
    }

    public function test_une_liste_vide_affiche_un_message_et_un_bouton(): void
    {
        $contenu = $this->get('/devices')->getContent();

        $this->assertStringContainsString('Aucun équipement trouvé', $contenu);
        $this->assertStringContainsString(route('devices.create'), $contenu);
    }

    public function test_les_messages_de_validation_sont_en_francais(): void
    {
        $this->creerDonnees();

        // On ouvre le formulaire, puis on l'envoie vide : il doit revenir avec les erreurs.
        $this->get('/devices/create');
        $this->post('/devices', []);

        $contenu = html_entity_decode($this->get('/devices/create')->getContent(), ENT_QUOTES);

        $this->assertStringContainsString('Le nom de l\'équipement est obligatoire.', $contenu);
        $this->assertStringContainsString('La marque est obligatoire.', $contenu);
    }

    public function test_les_champs_obligatoires_sont_signales_dans_la_session(): void
    {
        $this->creerDonnees();

        $this->post('/devices', [])
            ->assertSessionHasErrors(['nom', 'marque', 'numero_serie', 'etat', 'date_achat', 'room_id']);
    }

    public function test_une_suppression_passe_par_une_page_de_confirmation(): void
    {
        $this->creerDonnees();

        $device = Device::first();

        $response = $this->get('/devices/'.$device->id.'/delete');

        $response->assertOk();
        $response->assertSee('Confirmer la suppression');
        $response->assertSee('Oui, supprimer');
        $response->assertSee($device->nom);
    }

    public function test_la_page_404_propose_un_retour(): void
    {
        $response = $this->get('/une-page-qui-nexiste-pas');

        $response->assertNotFound();

        $contenu = html_entity_decode($response->getContent(), ENT_QUOTES);

        $this->assertStringContainsString('404', $contenu);
        $this->assertStringContainsString('Retour à l\'accueil', $contenu);
    }
}
