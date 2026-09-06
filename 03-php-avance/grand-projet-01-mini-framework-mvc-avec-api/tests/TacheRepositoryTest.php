<?php

declare(strict_types=1);

namespace App\Tests;

use App\Models\TacheRepository;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Ces tests utilisent une base SQLite EN MÉMOIRE plutôt qu'un vrai serveur
 * MySQL : plus rapide, ne nécessite aucune installation, et chaque test
 * démarre avec une base parfaitement vide et isolée des autres tests.
 * TacheRepository n'utilise que du SQL standard (aucune syntaxe propre à
 * MySQL), donc il fonctionne à l'identique sur les deux moteurs.
 */
class TacheRepositoryTest extends TestCase
{
    private TacheRepository $repository;

    protected function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $pdo->exec(
            "CREATE TABLE taches (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                titre TEXT NOT NULL,
                description TEXT,
                terminee INTEGER NOT NULL DEFAULT 0,
                creee_le TEXT DEFAULT CURRENT_TIMESTAMP
            )"
        );

        $this->repository = new TacheRepository($pdo);
    }

    public function testCreerRetourneUnIdentifiantValide(): void
    {
        $id = $this->repository->creer('Faire les courses', 'Lait, œufs, pain');

        $this->assertGreaterThan(0, $id);
    }

    public function testTrouverRetourneLaTacheCreee(): void
    {
        $id = $this->repository->creer('Réviser PHP', '');

        $tache = $this->repository->trouver($id);

        $this->assertNotNull($tache);
        $this->assertSame('Réviser PHP', $tache['titre']);
    }

    public function testTrouverRetourneNullSiInexistante(): void
    {
        $this->assertNull($this->repository->trouver(999));
    }

    public function testModifierMetAJourLesChamps(): void
    {
        $id = $this->repository->creer('Titre initial', '');

        $succes = $this->repository->modifier($id, 'Titre modifié', 'Nouvelle description', true);

        $this->assertTrue($succes);

        $tache = $this->repository->trouver($id);
        $this->assertSame('Titre modifié', $tache['titre']);
        $this->assertSame(1, (int) $tache['terminee']);
    }

    public function testSupprimerRetireLaTache(): void
    {
        $id = $this->repository->creer('À supprimer', '');

        $this->repository->supprimer($id);

        $this->assertNull($this->repository->trouver($id));
    }

    public function testListerFiltreParRecherche(): void
    {
        $this->repository->creer('Acheter du pain', '');
        $this->repository->creer('Réviser les tests', '');

        $resultats = $this->repository->lister(recherche: 'pain');

        $this->assertCount(1, $resultats);
        $this->assertSame('Acheter du pain', $resultats[0]['titre']);
    }

    public function testListerRepliesSurUneColonneDeTriNonAutorisee(): void
    {
        $this->repository->creer('Tâche A', '');

        // "motDePasse" n'est PAS dans la liste blanche des colonnes triables :
        // ce test prouve que lister() ne lève pas d'erreur et retombe sur
        // le tri par défaut plutôt que d'exécuter du SQL invalide/dangereux.
        $resultats = $this->repository->lister(tri: 'motDePasse');

        $this->assertCount(1, $resultats);
    }

    public function testCompterRespecteLesFiltres(): void
    {
        $this->repository->creer('Tâche 1', '');
        $id2 = $this->repository->creer('Tâche 2', '');
        $this->repository->modifier($id2, 'Tâche 2', '', true);

        $this->assertSame(2, $this->repository->compter());
        $this->assertSame(1, $this->repository->compter(null, true));
        $this->assertSame(1, $this->repository->compter(null, false));
    }
}
