<?php

declare(strict_types=1);

namespace App;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Génère un rapport PDF à partir d'un tableau de lignes, sans dépendre
 * d'une base de données : les données proviennent d'un fichier CSV local
 * (module 01.8 : lecture de fichiers).
 */
class RapportGenerator
{
    public function genererDepuisCsv(string $cheminCsv, string $titre): string
    {
        $lignes = $this->lireCsv($cheminCsv);
        $html = $this->construireHtml($titre, $lignes);

        return $this->convertirEnPdf($html);
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function lireCsv(string $chemin): array
    {
        if (!is_readable($chemin)) {
            throw new \RuntimeException("Fichier introuvable ou illisible : $chemin");
        }

        $lignes = [];
        $poignee = fopen($chemin, 'r');
        $entetes = fgetcsv($poignee);

        while (($donnees = fgetcsv($poignee)) !== false) {
            $lignes[] = array_combine($entetes, $donnees);
        }

        fclose($poignee);

        return $lignes;
    }

    /**
     * @param array<int, array<string, string>> $lignes
     */
    private function construireHtml(string $titre, array $lignes): string
    {
        $titreEchappe = htmlspecialchars($titre, ENT_QUOTES, 'UTF-8');

        $html = "<h1>$titreEchappe</h1>";
        $html .= '<p>Généré le ' . date('d/m/Y à H:i') . '</p>';
        $html .= '<table border="1" cellpadding="6" style="border-collapse: collapse; width: 100%;">';

        if ($lignes !== []) {
            $html .= '<thead><tr>';
            foreach (array_keys($lignes[0]) as $colonne) {
                $html .= '<th>' . htmlspecialchars($colonne, ENT_QUOTES, 'UTF-8') . '</th>';
            }
            $html .= '</tr></thead><tbody>';

            foreach ($lignes as $ligne) {
                $html .= '<tr>';
                foreach ($ligne as $valeur) {
                    $html .= '<td>' . htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8') . '</td>';
                }
                $html .= '</tr>';
            }

            $html .= '</tbody>';
        }

        $html .= '</table>';

        return $html;
    }

    private function convertirEnPdf(string $html): string
    {
        $options = new Options();
        $options->set('isRemoteEnabled', false); // sécurité : pas de chargement de ressources distantes

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
