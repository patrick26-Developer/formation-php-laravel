<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Commande Artisan personnalisée : analyse un fichier de log Laravel et
 * affiche un résumé par niveau de gravité, SANS toucher à la base de
 * données — un rappel qu'Artisan n'est pas réservé aux commandes liées
 * à Eloquent (make:model, migrate...) : c'est un framework CLI généraliste.
 */
class AnalyserLogsCommand extends Command
{
    /**
     * La "signature" définit le nom, les arguments et les options de la
     * commande — comparez avec argv du module 01.9 : Artisan automatise
     * entièrement le parsing que vous auriez fait à la main avec $argv.
     */
    protected $signature = 'logs:analyser
        {chemin? : Chemin du fichier de log (par défaut : storage/logs/laravel.log)}
        {--niveau= : Ne compter qu\'un niveau précis (ex: error)}';

    protected $description = 'Analyse un fichier de log Laravel et affiche un résumé par niveau de gravité.';

    private const NIVEAUX_CONNUS = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'];

    public function handle(): int
    {
        $chemin = $this->argument('chemin') ?? storage_path('logs/laravel.log');

        if (!is_readable($chemin)) {
            $this->error("Fichier introuvable ou illisible : $chemin");

            return self::FAILURE; // convention Artisan : code de sortie non-zéro en cas d'échec
        }

        $compteurs = $this->compterParNiveau($chemin);

        $niveauFiltre = $this->option('niveau');
        if ($niveauFiltre !== null) {
            $compteurs = array_intersect_key($compteurs, [$niveauFiltre => true]);
        }

        $this->afficherResultats($chemin, $compteurs);

        return self::SUCCESS;
    }

    /**
     * @return array<string, int>
     */
    private function compterParNiveau(string $chemin): array
    {
        $compteurs = array_fill_keys(self::NIVEAUX_CONNUS, 0);

        $poignee = fopen($chemin, 'r');

        while (($ligne = fgets($poignee)) !== false) {
            foreach (self::NIVEAUX_CONNUS as $niveau) {
                // Format standard d'une ligne Laravel :
                // [2026-09-06 14:32:10] local.ERROR: Message...
                if (str_contains($ligne, '.' . strtoupper($niveau) . ':')) {
                    $compteurs[$niveau]++;
                    break;
                }
            }
        }

        fclose($poignee);

        return array_filter($compteurs, fn (int $n) => $n > 0);
    }

    /**
     * @param array<string, int> $compteurs
     */
    private function afficherResultats(string $chemin, array $compteurs): void
    {
        $this->info("Analyse de : $chemin");
        $this->newLine();

        if ($compteurs === []) {
            $this->line('Aucune entrée de log correspondante trouvée.');

            return;
        }

        // $this->table() : affichage tabulaire natif d'Artisan, aligné
        // automatiquement — inutile de gérer soi-même le padding des colonnes.
        $this->table(
            ['Niveau', 'Occurrences'],
            collect($compteurs)
                ->sortDesc()
                ->map(fn (int $n, string $niveau) => [strtoupper($niveau), $n])
                ->values()
                ->toArray()
        );

        $total = array_sum($compteurs);
        $this->newLine();
        $this->comment("Total : $total entrées.");

        if (($compteurs['critical'] ?? 0) > 0 || ($compteurs['emergency'] ?? 0) > 0) {
            $this->warn('⚠️  Des entrées critiques ont été détectées — investigation recommandée.');
        }
    }
}
