<?php

declare(strict_types=1);

namespace App\Tests;

use App\RapportGenerator;
use PHPUnit\Framework\TestCase;

final class RapportGeneratorTest extends TestCase
{
    private string $cheminCsvTemporaire;

    protected function setUp(): void
    {
        $this->cheminCsvTemporaire = tempnam(sys_get_temp_dir(), 'test_csv');
        file_put_contents($this->cheminCsvTemporaire, "Produit,Prix\nClavier,49.99\nSouris,19.99\n");
    }

    protected function tearDown(): void
    {
        unlink($this->cheminCsvTemporaire);
    }

    public function test_genere_un_pdf_valide_a_partir_dun_csv(): void
    {
        $generateur = new RapportGenerator();

        $pdf = $generateur->genererDepuisCsv($this->cheminCsvTemporaire, 'Rapport de test');

        // Un fichier PDF valide commence toujours par cette signature binaire.
        $this->assertStringStartsWith('%PDF', $pdf);
    }

    public function test_leve_une_exception_si_le_fichier_est_introuvable(): void
    {
        $generateur = new RapportGenerator();

        $this->expectException(\RuntimeException::class);

        $generateur->genererDepuisCsv('/chemin/inexistant.csv', 'Rapport');
    }
}
