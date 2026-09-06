<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Vue;
use App\Models\TacheRepository;

class TacheWebController
{
    public function __construct(private TacheRepository $taches)
    {
    }

    public function liste(): void
    {
        $tri = $_GET['tri'] ?? 'creee_le';
        $ordre = $_GET['ordre'] ?? 'DESC';
        $recherche = $_GET['recherche'] ?? null;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $parPage = 5;

        $taches = $this->taches->lister(tri: $tri, ordre: $ordre, recherche: $recherche, page: $page, parPage: $parPage);
        $total = $this->taches->compter($recherche);
        $totalPages = max(1, (int) ceil($total / $parPage));

        Vue::afficher('taches/liste', [
            'taches' => $taches,
            'tri' => $tri,
            'ordre' => $ordre,
            'recherche' => $recherche,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function formulaireCreation(): void
    {
        Vue::afficher('taches/creer', ['erreur' => null]);
    }

    public function creer(): void
    {
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($titre === '') {
            Vue::afficher('taches/creer', ['erreur' => 'Le titre est requis.']);
            return;
        }

        $this->taches->creer($titre, $description);

        header('Location: /taches');
        exit;
    }
}
