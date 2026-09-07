<?php

declare(strict_types=1);

namespace App\Cache;

/**
 * Cache fichier minimal : pas de base de données, pas de Redis — un simple
 * fichier JSON par clé, avec une date d'expiration. Suffisant pour un outil
 * CLI à faible fréquence d'utilisation (rappel du principe du module 08.2 :
 * la complexité d'une solution doit être proportionnée au besoin réel).
 */
class FileCache
{
    public function __construct(private readonly string $dossier)
    {
        if (!is_dir($this->dossier)) {
            mkdir($this->dossier, 0755, true);
        }
    }

    /**
     * @param callable(): array<string, mixed> $callback
     * @return array<string, mixed>
     */
    public function remember(string $cle, int $dureeSecondes, callable $callback): array
    {
        $chemin = $this->cheminPour($cle);

        if (is_file($chemin)) {
            $contenu = json_decode((string) file_get_contents($chemin), true);

            if (is_array($contenu) && ($contenu['expire_le'] ?? 0) > time()) {
                return $contenu['donnees'];
            }
        }

        $donnees = $callback();

        file_put_contents($chemin, json_encode([
            'expire_le' => time() + $dureeSecondes,
            'donnees' => $donnees,
        ], JSON_PRETTY_PRINT));

        return $donnees;
    }

    public function oublier(string $cle): void
    {
        $chemin = $this->cheminPour($cle);

        if (is_file($chemin)) {
            unlink($chemin);
        }
    }

    private function cheminPour(string $cle): string
    {
        // Un hash évite tout problème de caractères invalides dans un nom de fichier.
        return $this->dossier . '/' . md5($cle) . '.json';
    }
}
