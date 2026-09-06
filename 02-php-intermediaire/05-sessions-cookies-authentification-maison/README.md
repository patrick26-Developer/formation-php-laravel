# 02.5 — Sessions, cookies et authentification maison

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre la différence entre session et cookie.
- Utiliser `$_SESSION` pour maintenir un état entre plusieurs requêtes.
- Construire un système d'inscription/connexion avec hachage sécurisé des mots de passe.
- Protéger des pages nécessitant une authentification.

## 📋 Prérequis

[02.4 — Gestion des exceptions](../04-gestion-exceptions/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Pourquoi PHP a besoin de "se souvenir" de l'utilisateur ?

HTTP est un protocole **sans état** (*stateless*) : chaque requête est totalement indépendante de la précédente. Sans mécanisme particulier, un serveur ne peut pas savoir si deux requêtes proviennent du même visiteur. Les **sessions** et **cookies** résolvent ce problème.

| | Cookie | Session |
|---|---|---|
| Stockage réel des données | Dans le navigateur du client | Sur le serveur (le cookie ne contient qu'un identifiant) |
| Visible/modifiable par l'utilisateur | Oui | Non directement |
| Cas d'usage typique | Préférences légères, "se souvenir de moi" | Données sensibles (utilisateur connecté, panier) |

### Démarrer une session

```php
<?php
session_start(); // DOIT être appelé avant tout affichage HTML, en tout début de script

$_SESSION['visites'] = ($_SESSION['visites'] ?? 0) + 1;
echo "Vous avez visité cette page " . $_SESSION['visites'] . " fois.";
```

PHP place automatiquement un cookie (`PHPSESSID` par défaut) dans le navigateur, qui identifie la session sur le serveur à chaque requête suivante.

### Manipuler des cookies directement

```php
<?php
// setcookie(nom, valeur, expiration, chemin, domaine, https_uniquement, http_only)
setcookie('theme', 'sombre', time() + (86400 * 30), '/'); // expire dans 30 jours

echo $_COOKIE['theme'] ?? 'clair'; // lecture (disponible à partir de la requête SUIVANTE)
```

> ⚠️ `setcookie()` doit être appelé **avant tout affichage** (comme `session_start()`), car les cookies sont envoyés dans les en-têtes HTTP, qui doivent précéder le corps de la réponse.

### Hacher les mots de passe correctement

**Ne stockez jamais un mot de passe en clair.** PHP fournit des fonctions natives sûres, à utiliser systématiquement.

```php
<?php
$motDePasse = "MonMotDePasse123";

$hache = password_hash($motDePasse, PASSWORD_DEFAULT); // à stocker en base de données
// $hache ressemble à : $2y$10$eImiTXuWVxfM37uY4JANjQ...

// Pour vérifier un mot de passe saisi lors de la connexion :
if (password_verify("MonMotDePasse123", $hache)) {
    echo "Mot de passe correct";
}
```

> ⚠️ **Règle absolue de cette formation, sans exception** : tout mot de passe est traité par `password_hash()` avant stockage, et vérifié avec `password_verify()`. Ne jamais utiliser `md5()` ou `sha1()` pour des mots de passe (algorithmes rapides, donc vulnérables aux attaques par force brute — ce sujet est repris au [module 02.6](../06-securite-web-fondamentaux/README.md)).

### Construire une inscription et une connexion (simulation sans base de données)

Pour ce module, on simule un "annuaire" d'utilisateurs en mémoire. La vraie persistance en base de données arrive au [module 02.8](../08-pdo-bases-de-donnees-mysql/README.md).

```php
<?php
session_start();

// Simule une base de données d'utilisateurs (email => hash du mot de passe)
$utilisateursSimules = [
    'alice@example.com' => password_hash('secret123', PASSWORD_DEFAULT),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $motDePasse = $_POST['mot_de_passe'] ?? '';

    if (isset($utilisateursSimules[$email]) && password_verify($motDePasse, $utilisateursSimules[$email])) {
        $_SESSION['utilisateur_email'] = $email; // on marque l'utilisateur comme connecté
        header('Location: espace-membre.php');
        exit; // exit après un header('Location: ...') : essentiel, sinon le reste du script continue de s'exécuter
    }

    $erreur = "Email ou mot de passe incorrect.";
}
```

### Protéger une page (middleware maison)

```php
<?php
// espace-membre.php
session_start();

if (!isset($_SESSION['utilisateur_email'])) {
    header('Location: connexion.php');
    exit;
}

echo "Bienvenue, " . htmlspecialchars($_SESSION['utilisateur_email']);
```

### Se déconnecter

```php
<?php
session_start();
$_SESSION = []; // vide toutes les données de session
session_destroy(); // détruit la session côté serveur
header('Location: connexion.php');
exit;
```

## ✅ Points clés à retenir

- `session_start()` doit être appelé avant tout envoi de contenu HTML.
- `$_SESSION` stocke des données côté serveur, identifiées par un cookie contenant seulement un identifiant.
- `password_hash()`/`password_verify()` : la seule façon acceptable de gérer des mots de passe.
- `exit;` doit systématiquement suivre un `header('Location: ...')`.
- Protéger une page = vérifier `isset($_SESSION[...])` en tout début de script, avant tout traitement.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/book.session.php](https://www.php.net/manual/fr/book.session.php)
- [php.net/manual/fr/function.password-hash.php](https://www.php.net/manual/fr/function.password-hash.php)
- [Module 02.6 — Sécurité web fondamentale](../06-securite-web-fondamentaux/README.md)
- [Module 07.4 — Authentification Breeze/Fortify](../../07-laravel-intermediaire/04-authentification-breeze-fortify/README.md) (comment Laravel automatise tout ceci)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.4 — Gestion des exceptions](../04-gestion-exceptions/README.md) · **Suite :** [02.6 — Sécurité web fondamentale](../06-securite-web-fondamentaux/README.md)
