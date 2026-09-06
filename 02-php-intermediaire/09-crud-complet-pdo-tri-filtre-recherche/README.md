# 02.9 — CRUD complet avec PDO (tri, filtre, recherche)

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Structurer un CRUD complet (Create, Read, Update, Delete) avec PDO et POO.
- Ajouter le tri dynamique, le filtrage et la recherche à une liste de données.
- Implémenter une pagination simple.
- Organiser ce code en une classe "Repository" réutilisable.

## 📋 Prérequis

[02.8 — PDO et bases de données MySQL](../08-pdo-bases-de-donnees-mysql/README.md)

## ⏱️ Durée estimée

3h.

## 📖 Théorie

### CRUD : les 4 opérations fondamentales

CRUD = **C**reate, **R**ead, **U**pdate, **D**elete. C'est le socle de la quasi-totalité des applications web professionnelles : blog, gestion de tâches, e-commerce, back-office... **Chaque projet du reste de cette formation utilisera ce pattern**, que ce soit en PHP natif (ce module) ou via Eloquent avec Laravel (module 06.7).

### Organiser le CRUD dans une classe "Repository"

Plutôt que d'éparpiller des requêtes SQL dans toutes les pages, on centralise l'accès à une table dans une classe dédiée — un pattern appelé **Repository**, approfondi comme design pattern au [module 03.1](../../03-php-avance/01-design-patterns-php/README.md).

```php
<?php
declare(strict_types=1);

namespace App;

class TacheRepository {
    public function __construct(private \PDO $pdo) {}

    // CREATE
    public function creer(string $titre, string $description): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO taches (titre, description, terminee, creee_le) VALUES (:titre, :description, 0, NOW())"
        );
        $stmt->execute(['titre' => $titre, 'description' => $description]);

        return (int) $this->pdo->lastInsertId();
    }

    // READ (un seul enregistrement)
    public function trouver(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM taches WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $resultat = $stmt->fetch();

        return $resultat === false ? null : $resultat;
    }

    // UPDATE
    public function modifier(int $id, string $titre, string $description): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE taches SET titre = :titre, description = :description WHERE id = :id"
        );
        $stmt->execute(['titre' => $titre, 'description' => $description, 'id' => $id]);

        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function supprimer(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM taches WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
```

### READ avancé : tri, filtre, recherche, pagination

C'est ici que le "R" du CRUD devient réellement utile en production — une simple liste brute est rarement suffisante.

```php
<?php
class TacheRepository {
    // ... (méthodes précédentes) ...

    /**
     * @param string $tri Colonne sur laquelle trier (whitelistée pour la sécurité)
     * @param string $ordre 'ASC' ou 'DESC'
     * @param string|null $recherche Terme de recherche sur le titre
     * @param bool|null $terminee Filtre optionnel sur le statut
     */
    public function lister(
        string $tri = 'creee_le',
        string $ordre = 'DESC',
        ?string $recherche = null,
        ?bool $terminee = null,
        int $page = 1,
        int $parPage = 10,
    ): array {
        // ⚠️ IMPORTANT : $tri et $ordre viennent potentiellement de l'utilisateur
        // (paramètres d'URL). On ne peut PAS les passer en paramètre lié comme
        // une valeur classique (PDO ne permet pas de "binder" un nom de colonne),
        // donc on les valide contre une liste blanche AVANT de les insérer
        // directement dans la requête SQL.
        $colonnesAutorisees = ['titre', 'creee_le', 'terminee'];
        if (!in_array($tri, $colonnesAutorisees, true)) {
            $tri = 'creee_le';
        }

        $ordre = strtoupper($ordre) === 'ASC' ? 'ASC' : 'DESC';

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

        $decalage = ($page - 1) * $parPage;

        $sql = "SELECT * FROM taches $clauseOu ORDER BY $tri $ordre LIMIT :limite OFFSET :decalage";
        $stmt = $this->pdo->prepare($sql);

        foreach ($parametres as $cle => $valeur) {
            $stmt->bindValue(":$cle", $valeur);
        }
        $stmt->bindValue(':limite', $parPage, \PDO::PARAM_INT);
        $stmt->bindValue(':decalage', $decalage, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function compter(?string $recherche = null, ?bool $terminee = null): int {
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

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM taches $clauseOu");
        $stmt->execute($parametres);

        return (int) $stmt->fetch()['total'];
    }
}
```

> ⚠️ **Le point de sécurité le plus important de ce module** : `$tri` (le nom de la colonne) **ne peut pas** être passé comme paramètre lié classique — PDO ne permet de lier que des *valeurs*, pas des identifiants SQL (noms de colonnes/tables). C'est pourquoi on le valide contre une **liste blanche** (`$colonnesAutorisees`) avant de l'insérer dans la requête. Ne jamais insérer un paramètre de tri/colonne dans du SQL sans cette validation.

### Utilisation depuis une page (lien avec le module 01.7)

```php
<?php
$repository = new TacheRepository($pdo);

$tri = $_GET['tri'] ?? 'creee_le';
$ordre = $_GET['ordre'] ?? 'DESC';
$recherche = $_GET['recherche'] ?? null;
$page = max(1, (int) ($_GET['page'] ?? 1));

$taches = $repository->lister(tri: $tri, ordre: $ordre, recherche: $recherche, page: $page);
$total = $repository->compter(recherche: $recherche);
$totalPages = (int) ceil($total / 10);
```

```html
<a href="?tri=titre&ordre=ASC">Trier par titre ↑</a>
<a href="?tri=creee_le&ordre=DESC">Trier par date ↓</a>
<form method="GET">
    <input type="text" name="recherche" value="<?= htmlspecialchars($recherche ?? '') ?>">
    <button type="submit">Rechercher</button>
</form>
```

## ✅ Points clés à retenir

- Un Repository centralise toutes les requêtes SQL d'une table dans une seule classe.
- Un nom de colonne pour le tri doit **toujours** être validé contre une liste blanche, jamais lié comme une valeur classique.
- `LIKE '%terme%'` pour une recherche partielle, avec la valeur passée en paramètre lié.
- `LIMIT`/`OFFSET` pour la pagination, en plus d'un `COUNT(*)` pour connaître le nombre total de pages.
- Ce pattern Repository + tri/filtre/recherche/pagination est directement transposable à Eloquent au [module 06.7](../../06-laravel-fondamentaux/07-crud-complet-laravel-tri-filtre-recherche/README.md).

## ➡️ Pour aller plus loin

- [dev.mysql.com — LIMIT](https://dev.mysql.com/doc/refman/8.0/en/select.html) (clause `LIMIT ... OFFSET`)
- [Module 03.1 — Design patterns en PHP](../../03-php-avance/01-design-patterns-php/README.md) (le pattern Repository en détail)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.8 — PDO et bases de données MySQL](../08-pdo-bases-de-donnees-mysql/README.md) · **Suite :** [Mini-projet : Gestionnaire de tâches (CRUD PDO)](../projet-mini-02-gestion-taches-crud-pdo/README.md)
