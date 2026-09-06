<?php

declare(strict_types=1);

/**
 * Solution cumulative des exercices 1 à 4 : chaque exercice ajoute des
 * fonctionnalités à cette même classe (CRUD de base, puis tri, puis
 * recherche/filtre, puis pagination).
 */
class LivreRepository {
    private const COLONNES_TRI_AUTORISEES = ['titre', 'auteur', 'annee'];

    public function __construct(private PDO $pdo) {}

    // --- Exercice 1 : CRUD de base ---

    public function creer(string $titre, string $auteur, int $annee): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO livres (titre, auteur, annee) VALUES (:titre, :auteur, :annee)"
        );
        $stmt->execute(['titre' => $titre, 'auteur' => $auteur, 'annee' => $annee]);

        return (int) $this->pdo->lastInsertId();
    }

    public function trouver(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM livres WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $resultat = $stmt->fetch();

        return $resultat === false ? null : $resultat;
    }

    public function modifier(int $id, string $titre, string $auteur, int $annee): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE livres SET titre = :titre, auteur = :auteur, annee = :annee WHERE id = :id"
        );
        $stmt->execute(['titre' => $titre, 'auteur' => $auteur, 'annee' => $annee, 'id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public function supprimer(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM livres WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    // --- Exercices 2, 3, 4 : lister() avec tri, recherche, filtre, pagination ---

    public function lister(
        string $tri = 'annee',
        string $ordre = 'DESC',
        ?string $recherche = null,
        ?bool $disponible = null,
        int $page = 1,
        int $parPage = 10,
    ): array {
        // Exercice 2 : liste blanche pour le nom de colonne de tri
        if (!in_array($tri, self::COLONNES_TRI_AUTORISEES, true)) {
            $tri = 'annee';
        }
        $ordre = strtoupper($ordre) === 'ASC' ? 'ASC' : 'DESC';

        [$clauseOu, $parametres] = $this->construireFiltres($recherche, $disponible);

        // Exercice 4 : pagination
        $decalage = ($page - 1) * $parPage;

        $sql = "SELECT * FROM livres $clauseOu ORDER BY $tri $ordre LIMIT :limite OFFSET :decalage";
        $stmt = $this->pdo->prepare($sql);

        foreach ($parametres as $cle => $valeur) {
            $stmt->bindValue(":$cle", $valeur);
        }
        $stmt->bindValue(':limite', $parPage, PDO::PARAM_INT);
        $stmt->bindValue(':decalage', $decalage, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function compter(?string $recherche = null, ?bool $disponible = null): int {
        [$clauseOu, $parametres] = $this->construireFiltres($recherche, $disponible);

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM livres $clauseOu");
        $stmt->execute($parametres);

        return (int) $stmt->fetch()['total'];
    }

    /**
     * Exercice 3 : construit la clause WHERE et les paramètres liés communs
     * à lister() et compter(), pour ne pas dupliquer cette logique.
     *
     * @return array{0: string, 1: array<string, mixed>}
     */
    private function construireFiltres(?string $recherche, ?bool $disponible): array {
        $conditions = [];
        $parametres = [];

        if ($recherche !== null && $recherche !== '') {
            // Recherche sur titre OU auteur
            $conditions[] = "(titre LIKE :recherche OR auteur LIKE :recherche)";
            $parametres['recherche'] = '%' . $recherche . '%';
        }

        if ($disponible !== null) {
            $conditions[] = "disponible = :disponible";
            $parametres['disponible'] = (int) $disponible;
        }

        $clauseOu = $conditions !== [] ? "WHERE " . implode(" AND ", $conditions) : "";

        return [$clauseOu, $parametres];
    }
}
