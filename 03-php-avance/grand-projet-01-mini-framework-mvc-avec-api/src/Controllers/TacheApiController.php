<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Reponse;
use App\Models\TacheRepository;

/**
 * Expose les mêmes tâches que TacheWebController, mais en JSON.
 * Remarquez : AUCUNE logique métier n'est dupliquée, seul le format de
 * sortie change — c'est tout l'intérêt d'avoir isolé TacheRepository.
 */
class TacheApiController
{
    public function __construct(private TacheRepository $taches)
    {
    }

    public function liste(): void
    {
        $recherche = $_GET['recherche'] ?? null;
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $taches = $this->taches->lister(recherche: $recherche, page: $page);
        $total = $this->taches->compter($recherche);

        Reponse::json([
            'succes' => true,
            'donnees' => $taches,
            'meta' => ['total' => $total, 'page' => $page],
        ]);
    }

    public function afficher(string $id): void
    {
        $tache = $this->taches->trouver((int) $id);

        if ($tache === null) {
            Reponse::json(['succes' => false, 'erreur' => 'Tâche non trouvée.'], 404);
        }

        Reponse::json(['succes' => true, 'donnees' => $tache]);
    }

    public function creer(): void
    {
        $donnees = Reponse::corpsJson();

        if (empty($donnees['titre'])) {
            Reponse::json(['succes' => false, 'erreur' => 'Le champ "titre" est requis.'], 400);
        }

        $id = $this->taches->creer($donnees['titre'], $donnees['description'] ?? '');
        $tache = $this->taches->trouver($id);

        Reponse::json(['succes' => true, 'donnees' => $tache], 201);
    }

    public function modifier(string $id): void
    {
        $tache = $this->taches->trouver((int) $id);

        if ($tache === null) {
            Reponse::json(['succes' => false, 'erreur' => 'Tâche non trouvée.'], 404);
        }

        $donnees = Reponse::corpsJson();
        $titre = $donnees['titre'] ?? $tache['titre'];
        $description = $donnees['description'] ?? $tache['description'];
        $terminee = $donnees['terminee'] ?? (bool) $tache['terminee'];

        $this->taches->modifier((int) $id, $titre, $description, $terminee);

        Reponse::json(['succes' => true, 'donnees' => $this->taches->trouver((int) $id)]);
    }

    public function supprimer(string $id): void
    {
        $tache = $this->taches->trouver((int) $id);

        if ($tache === null) {
            Reponse::json(['succes' => false, 'erreur' => 'Tâche non trouvée.'], 404);
        }

        $this->taches->supprimer((int) $id);

        Reponse::json(null, 204);
    }
}
