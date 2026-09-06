# 02.8 — PDO et bases de données MySQL

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Se connecter à une base de données MySQL depuis PHP avec PDO.
- Exécuter des requêtes préparées en toute sécurité.
- Récupérer des résultats sous différentes formes.
- Gérer les erreurs de base de données proprement.

## 📋 Prérequis

[02.7 — Composer, autoload, PSR](../07-composer-autoload-psr/README.md) et une base MySQL/MariaDB installée (voir [00.2](../../00-introduction/02-installation-environnement/README.md)).

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Pourquoi PDO ?

**PDO** (PHP Data Objects) est une couche d'abstraction pour accéder à des bases de données en PHP. Contrairement à l'ancienne extension `mysqli` (liée exclusivement à MySQL), PDO fonctionne avec plusieurs moteurs (MySQL, PostgreSQL, SQLite...) via une **API unique**, et propose nativement les requêtes préparées — la protection contre l'injection SQL vue au [module 02.6](../06-securite-web-fondamentaux/README.md).

### Se connecter à MySQL

```php
<?php
declare(strict_types=1);

$hote = '127.0.0.1';
$base = 'formation_php';
$utilisateur = 'root';
$motDePasse = '';

try {
    $pdo = new PDO(
        "mysql:host=$hote;dbname=$base;charset=utf8mb4",
        $utilisateur,
        $motDePasse,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // lève des exceptions en cas d'erreur SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // résultats sous forme de tableaux associatifs
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
```

> ⚠️ Ne codez **jamais** les identifiants de connexion en dur dans un fichier versionné. Ce module simplifie volontairement pour l'apprentissage ; le [module 02.9](../09-crud-complet-pdo-tri-filtre-recherche/README.md) et les projets suivants utiliseront un fichier de configuration séparé, non versionné (`.env`, voir [00.3](../../00-introduction/03-git-github-essentiels/README.md)).

### Créer une table (rappel SQL, approfondi au [niveau 04](../../04-bases-de-donnees-approfondi/README.md))

```sql
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    cree_le DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### INSERT avec requête préparée

```php
<?php
$stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email) VALUES (:nom, :email)");
$stmt->execute([
    'nom' => 'Alice Dupont',
    'email' => 'alice@example.com',
]);

$nouvelId = $pdo->lastInsertId(); // récupère l'ID auto-incrémenté généré
echo "Utilisateur créé avec l'ID $nouvelId";
```

### SELECT et récupération des résultats

```php
<?php
// Récupérer UN seul enregistrement
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id");
$stmt->execute(['id' => 1]);
$utilisateur = $stmt->fetch(); // un tableau associatif, ou false si aucun résultat

// Récupérer PLUSIEURS enregistrements
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom LIKE :recherche");
$stmt->execute(['recherche' => '%Dupont%']);
$utilisateurs = $stmt->fetchAll(); // un tableau de tableaux associatifs

foreach ($utilisateurs as $utilisateur) {
    echo $utilisateur['nom'] . " - " . $utilisateur['email'] . "\n";
}
```

### UPDATE et DELETE

```php
<?php
// UPDATE
$stmt = $pdo->prepare("UPDATE utilisateurs SET nom = :nom WHERE id = :id");
$stmt->execute(['nom' => 'Alice Martin', 'id' => 1]);
echo $stmt->rowCount() . " ligne(s) modifiée(s)";

// DELETE
$stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
$stmt->execute(['id' => 1]);
echo $stmt->rowCount() . " ligne(s) supprimée(s)";
```

### Placeholders nommés vs positionnels

```php
<?php
// Nommés (recommandé : plus lisible, surtout avec plusieurs paramètres)
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom = :nom AND email = :email");
$stmt->execute(['nom' => 'Alice', 'email' => 'alice@example.com']);

// Positionnels (avec ?)
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom = ? AND email = ?");
$stmt->execute(['Alice', 'alice@example.com']); // l'ordre doit correspondre exactement
```

### Gérer les erreurs SQL

Avec `PDO::ERRMODE_EXCEPTION` configuré à la connexion, toute erreur SQL lève une `PDOException`, capturable comme toute exception (module 02.4) :

```php
<?php
try {
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email) VALUES (:nom, :email)");
    $stmt->execute(['nom' => 'Bob', 'email' => 'alice@example.com']); // email déjà utilisé (UNIQUE)
} catch (PDOException $e) {
    echo "Erreur lors de la création : " . $e->getMessage();
    // En production, on loggerait $e plutôt que d'afficher le détail technique à l'utilisateur
}
```

### Encapsuler la connexion dans une classe (préparation au CRUD)

```php
<?php
declare(strict_types=1);

namespace App;

class Connexion {
    private static ?\PDO $instance = null;

    public static function obtenir(): \PDO {
        if (self::$instance === null) {
            self::$instance = new \PDO(
                "mysql:host=127.0.0.1;dbname=formation_php;charset=utf8mb4",
                "root",
                "",
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$instance;
    }
}
```

> 📌 Ce pattern Singleton (vu au [module 02.3](../03-poo-avancee-traits-static-magic-methods/README.md)) évite d'ouvrir une nouvelle connexion à chaque requête SQL dans un même script. Il annonce la structure du mini-projet de ce niveau.

## ✅ Points clés à retenir

- Toujours configurer `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` à la connexion.
- Toute donnée utilisateur passe dans `execute()`, jamais concaténée dans le SQL.
- `fetch()` pour un résultat, `fetchAll()` pour plusieurs.
- `lastInsertId()` après un `INSERT`, `rowCount()` après un `UPDATE`/`DELETE`.
- Encapsuler la connexion dans une classe dédiée facilite sa réutilisation dans tout un projet.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/book.pdo.php](https://www.php.net/manual/fr/book.pdo.php)
- [Niveau 04 — Bases de données approfondies](../../04-bases-de-donnees-approfondi/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.7 — Composer, autoload, PSR](../07-composer-autoload-psr/README.md) · **Suite :** [02.9 — CRUD complet PDO](../09-crud-complet-pdo-tri-filtre-recherche/README.md)
