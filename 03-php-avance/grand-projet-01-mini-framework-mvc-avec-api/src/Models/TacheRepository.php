<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * Repository CRUD + tri/filtre/recherche (module 02.9), utilisé à la fois
 * par le contrôleur web ET le contrôleur API : la logique d'accès aux
 * données n'est écrite qu'une seule fois.
 */
class TacheRepository
{
    private const COLONNES_TRI_AUTORISEES = ['titre', 'creee_le', 'terminee'];

    public function __construct(private PDO $pdo)
    {
    }

    public function creer(string $titre, string $description): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO taches (titre, description, terminee) VALUES (:titre, :description, 0)"
        );
        $stmt->execute(['titre' => $titre, 'description' => $description]);

        return (int) $this->pdo->lastInsertId();
    }

    public function trouver(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM taches WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $resultat = $stmt->fetch();

        return $resultat === false ? null : $resultat;
    }

    public function modifier(int $id, string $titre, string $description, bool $terminee): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE taches SET titre = :titre, description = :description, terminee = :terminee WHERE id = :id"
        );
        $stmt->execute([
            'titre' => $titre,
            'description' => $description,
            'terminee' => (int) $terminee,
            'id' => $id,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function supprimer(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM taches WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public function lister(
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

        [$clauseOu, $parametres] = $this->construireFiltres($recherche, $terminee);
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

    public function compter(?string $recherche = null, ?bool $terminee = null): int
    {
        [$clauseOu, $parametres] = $this->construireFiltres($recherche, $terminee);

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM taches $clauseOu");
        $stmt->execute($parametres);

        return (int) $stmt->fetch()['total'];
    }

    private function construireFiltres(?string $recherche, ?bool $terminee): array
    {
        $conditions = [];
        $parametres = [];

        if ($recherche !== null && $recherche !== '') {
            $conditions[] = "titre LIKE :recherche";
            $parametres['recherche'] = '%' . $recherche . '%';
        }

        if ($terminee !== null) {
            $conditions[] = "terminee = :terminee";
            $parametres['terminee'] = (int) $terminee;
        }

        $clauseOu = $conditions !== [] ? "WHERE " . implode(" AND ", $conditions) : "";

        return [$clauseOu, $parametres];
    }
}
