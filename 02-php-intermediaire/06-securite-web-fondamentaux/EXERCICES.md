# Exercices — 02.6 Sécurité web fondamentale

## Exercice 1 — Identifier les failles (facile)

Pour chacun de ces extraits de code, identifiez la faille (injection SQL, XSS, ou aucune) et expliquez pourquoi en commentaire :

```php
// A
echo "Bonjour " . $_GET['nom'];

// B
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);

// C
$requete = "SELECT * FROM produits WHERE nom = '" . $_GET['nom'] . "'";
$pdo->query($requete);

// D
echo "Bonjour " . htmlspecialchars($_GET['nom']);
```

## Exercice 2 — Générateur de jeton CSRF réutilisable (facile)

Écrivez une fonction `genererJetonCsrf(): string` qui crée (ou réutilise s'il existe déjà) un jeton dans `$_SESSION['jeton_csrf']`, et une fonction `verifierJetonCsrf(string $jetonRecu): bool` qui le compare avec `hash_equals()`. Testez les deux fonctions.

## Exercice 3 — Formulaire protégé par CSRF (moyen)

Construisez un formulaire complet avec un champ caché contenant le jeton CSRF (utilisez vos fonctions de l'exercice 2). Au traitement du formulaire, vérifiez le jeton et refusez la requête (code HTTP 403) si le jeton est absent ou incorrect. Testez en soumettant le formulaire normalement, puis en simulant une requête sans le bon jeton (retirez le champ caché manuellement dans le HTML avant de soumettre, via les outils de développement du navigateur).

## Exercice 4 — Recherche sécurisée (moyen)

Vous avez ce code dangereux :

```php
<?php
$terme = $_GET['q'] ?? '';
$requete = "SELECT * FROM articles WHERE titre LIKE '%$terme%'";
```

Réécrivez-le en utilisant une requête préparée avec PDO (vous pouvez simuler `$pdo` par un commentaire si vous n'avez pas encore de base de données — l'objectif est la syntaxe correcte de la requête préparée avec un `LIKE`).

## Exercice 5 — Audit de mini-application (difficile)

Ce mini-script contient **trois failles distinctes** (une de chaque type vu dans ce module, en supposant qu'il gère aussi une connexion). Listez-les toutes en commentaire, puis réécrivez une version corrigée complète.

```php
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recherche = $_GET['recherche'];
    $requete = "SELECT * FROM produits WHERE nom LIKE '%$recherche%'";
    // ... exécution de $requete avec $pdo->query() ...

    echo "Résultats pour : " . $recherche;

    if ($_POST['action'] === 'supprimer_compte') {
        // suppression du compte, sans aucune vérification de jeton
    }
}
```

---

Comparez avec [solutions/](solutions/) une fois terminé.
