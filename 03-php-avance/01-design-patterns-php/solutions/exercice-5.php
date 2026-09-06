<?php

declare(strict_types=1);

interface CritereTri {
    public function versSql(): string;
}

class TriParAnnee implements CritereTri {
    public function __construct(private string $ordre = 'DESC') {}

    public function versSql(): string {
        $ordre = strtoupper($this->ordre) === 'ASC' ? 'ASC' : 'DESC';
        return "annee $ordre";
    }
}

class TriParTitre implements CritereTri {
    public function __construct(private string $ordre = 'ASC') {}

    public function versSql(): string {
        $ordre = strtoupper($this->ordre) === 'ASC' ? 'ASC' : 'DESC';
        return "titre $ordre";
    }
}

class LivreRepository {
    public function __construct(private PDO $pdo) {}

    public function lister(CritereTri $tri): array {
        // Le nom de colonne ne vient JAMAIS directement de l'utilisateur ici :
        // il vient d'une classe PHP qu'on a nous-même écrite et validée.
        // C'est le SEUL type autorisé à produire cette portion de SQL.
        $sql = "SELECT * FROM livres ORDER BY " . $tri->versSql();
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll();
    }
}

/*
 * Comparaison avec la liste blanche du module 02.9 :
 *
 * AVANTAGE de cette approche par Strategy :
 * - Impossible de se tromper : on ne peut PAS passer une chaîne arbitraire,
 *   seulement une instance d'une classe PHP existante qui implémente
 *   CritereTri. Le typage du langage empêche l'erreur à la compilation/l'analyse
 *   statique, pas seulement à l'exécution.
 * - Chaque critère de tri peut avoir sa propre logique (validation d'ordre,
 *   valeur par défaut...) proprement encapsulée.
 *
 * INCONVÉNIENT :
 * - Plus verbeux pour un besoin simple : il faut une classe par critère de tri,
 *   alors qu'une liste blanche (un simple tableau de chaînes autorisées)
 *   suffit largement pour un cas basique comme celui du module 02.9.
 *
 * Règle pratique : la liste blanche convient très bien pour un petit nombre
 * de colonnes triables. La Strategy devient intéressante si la logique de tri
 * se complexifie (tri combiné sur plusieurs colonnes, tri calculé...).
 */
