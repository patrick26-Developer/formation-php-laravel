<?php

declare(strict_types=1);

/**
 * Repository du CRUD "tâches" (module 02.9) : chaque méthode ne concerne
 * QUE les tâches d'un utilisateur donné (utilisateur_id), pour qu'un
 * utilisateur ne puisse jamais voir ou modifier les tâches d'un autre.
 */
class TacheRepository {
    private const COLONNES_TRI_AUTORISEES = ['titre', 'creee_le', 'terminee'];

    public function __construct(private PDO $pdo) {}

    public function creer(int $utilisateurId, string $titre, string $description): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO taches (utilisateur_id, titre, description, terminee)
             VALUES (:utilisateur_id, :titre, :description, 0)"
        );
        $stmt->execute([
            'utilisateur_id' => $utilisateurId,
            'titre' => $titre,
            'description' => $description,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function trouver(int $id, int $utilisateurId): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM taches WHERE id = :id AND utilisateur_id = :utilisateur_id"
        );
        $stmt->execute(['id' => $id, 'utilisateur_id' => $utilisateurId]);
        $resultat = $stmt->fetch();

        return $resultat === false ? null : $resultat;
    }

    public function modifier(int $id, int $utilisateurId, string $titre, string $description, bool $terminee): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE taches SET titre = :titre, description = :description, terminee = :terminee
             WHERE id = :id AND utilisateur_id = :utilisateur_id"
        );
        $stmt->execute([
            'titre' => $titre,
            'description' => $description,
            'terminee' => (int) $terminee,
            'id' => $id,
            'utilisateur_id' => $utilisateurId,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function supprimer(int $id, int $utilisateurId): bool {
        $stmt = $this->pdo->prepare(
            "DELETE FROM taches WHERE id = :id AND utilisateur_id = :utilisateur_id"
        );
        $stmt->execute(['id' => $id, 'utilisateur_id' => $utilisateurId]);

        return $stmt->rowCount() > 0;
    }

    public function lister(
        int $utilisateurId,
        string $tri = 'creee_le',
        string $ordre = 'DESC',
        ?string $recherche = null,
        ?bool $terminee = null,
        int $page = 1,
        int $parPage = 10,
    ): array {
        if (!in_array($tri, self::COLONNES_TRI_AUTORISEES, true)) {
            $tri = 'creee_le';
        }
        $ordre = strtoupper($ordre) === 'ASC' ? 'ASC' : 'DESC';

        [$clauseOu, $parametres] = $this->construireFiltres($utilisateurId, $recherche, $terminee);
        $decalage = ($page - 1) * $parPage;

        $sql = "SELECT * FROM taches $clauseOu ORDER BY $tri $ordre LIMIT :limite OFFSET :decalage";
        $stmt = $this->pdo->prepare($sql);

        foreach ($parametres as $cle => $valeur) {
            $stmt->bindValue(":$cle", $valeur);
        }
        $stmt->bindValue(':limite', $parPage, PDO::PARAM_INT);
        $stmt->bindValue(':decalage', $decalage, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function compter(int $utilisateurId, ?string $recherche = null, ?bool $terminee = null): int {
        [$clauseOu, $parametres] = $this->construireFiltres($utilisateurId, $recherche, $terminee);

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM taches $clauseOu");
        $stmt->execute($parametres);

        return (int) $stmt->fetch()['total'];
    }

    /**
     * @return array{0: string, 1: array<string, mixed>}
     */
    private function construireFiltres(int $utilisateurId, ?string $recherche, ?bool $terminee): array {
        $conditions = ["utilisateur_id = :utilisateur_id"];
        $parametres = ['utilisateur_id' => $utilisateurId];

        if ($recherche !== null && $recherche !== '') {
            $conditions[] = "titre LIKE :recherche";
            $parametres['recherche'] = '%' . $recherche . '%';
        }

        if ($terminee !== null) {
            $conditions[] = "terminee = :terminee";
            $parametres['terminee'] = (int) $terminee;
        }

        return ["WHERE " . implode(" AND ", $conditions), $parametres];
    }
}
