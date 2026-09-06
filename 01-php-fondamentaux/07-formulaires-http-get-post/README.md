# 01.7 — Formulaires HTML et requêtes GET/POST

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre la différence entre les méthodes HTTP `GET` et `POST`.
- Créer un formulaire HTML et traiter ses données côté PHP.
- Valider et nettoyer les données reçues d'un utilisateur.
- Se protéger des premières failles de sécurité liées aux formulaires (XSS basique).

## 📋 Prérequis

[01.6 — Chaînes de caractères et regex](../06-chaines-de-caracteres/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### GET vs POST : quelle différence ?

| | `GET` | `POST` |
|---|---|---|
| Où sont les données ? | Dans l'URL (`?nom=Alice&age=28`) | Dans le corps de la requête (invisible dans l'URL) |
| Visible/partageable ? | Oui (favoris, historique) | Non |
| Taille limitée ? | Oui (quelques Ko selon navigateurs) | Non (ou très large) |
| Cas d'usage typique | Recherche, filtres, pagination | Connexion, inscription, envoi de données sensibles ou volumineuses |

### Un formulaire HTML simple

```html
<form action="traiter.php" method="POST">
    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required>

    <label for="age">Âge :</label>
    <input type="number" id="age" name="age" required>

    <button type="submit">Envoyer</button>
</form>
```

L'attribut `name` de chaque champ est la **clé** sous laquelle PHP recevra la valeur.

### Récupérer les données côté PHP

```php
<?php
// traiter.php

$prenom = $_POST['prenom'] ?? null;
$age = $_POST['age'] ?? null;

if ($prenom === null || $age === null) {
    echo "Données manquantes.";
    exit;
}

echo "Bonjour $prenom, vous avez $age ans.";
```

> 📌 On utilise systématiquement `?? null` (ou une valeur par défaut) plutôt que d'accéder directement à `$_POST['prenom']`, car si le champ est absent, PHP génère un avertissement ("Undefined array key").

Pour un formulaire en `GET`, on utilise `$_GET` de la même façon. `$_REQUEST` combine `$_GET`, `$_POST` et `$_COOKIE`, mais **son usage est déconseillé** dans cette formation : il est ambigu sur l'origine réelle de la donnée.

### Valider les données reçues

Ne **jamais faire confiance** aux données envoyées par un utilisateur, même via un formulaire que vous avez créé vous-même (un utilisateur malveillant peut envoyer une requête directement sans passer par votre formulaire).

```php
<?php
$age = $_POST['age'] ?? '';

if (!is_numeric($age)) {
    echo "L'âge doit être un nombre.";
    exit;
}

$age = (int) $age;

if ($age < 0 || $age > 150) {
    echo "Âge invalide.";
    exit;
}
```

Pour un email, `filter_var()` est l'outil recommandé :

```php
<?php
$email = $_POST['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email invalide.";
    exit;
}
```

### Se protéger du XSS lors de l'affichage

Si vous **réaffichez** une donnée saisie par l'utilisateur dans une page HTML, il faut l'échapper avec `htmlspecialchars()`, sinon un utilisateur malveillant pourrait injecter du code HTML/JavaScript (faille XSS — détaillée en profondeur au [module 02.6](../../02-php-intermediaire/06-securite-web-fondamentaux/README.md)).

```php
<?php
$commentaire = $_POST['commentaire'] ?? '';

// Sans protection : si $commentaire contient "<script>alert('piraté')</script>",
// ce script s'exécuterait dans le navigateur de tout visiteur de la page !
echo "<p>" . htmlspecialchars($commentaire) . "</p>";
```

> ⚠️ Retenez ce réflexe dès maintenant : **toute donnée utilisateur réaffichée en HTML passe par `htmlspecialchars()`**. C'est une des règles de sécurité les plus importantes de tout ce parcours.

## 💡 Exemple complet : formulaire + traitement

`formulaire.html` :
```html
<form action="index.php" method="POST">
    <input type="text" name="prenom" placeholder="Votre prénom" required>
    <input type="email" name="email" placeholder="Votre email" required>
    <button type="submit">Envoyer</button>
</form>
```

`index.php` :
```php
<?php
$erreurs = [];
$prenom = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($prenom === '') {
        $erreurs[] = "Le prénom est requis.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide.";
    }

    if (empty($erreurs)) {
        echo "Merci " . htmlspecialchars($prenom) . ", nous avons bien reçu votre email.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <?php foreach ($erreurs as $erreur): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endforeach; ?>

    <form action="index.php" method="POST">
        <input type="text" name="prenom" value="<?= htmlspecialchars($prenom) ?>" placeholder="Votre prénom">
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Votre email">
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
```

> 📌 `<?= $variable ?>` est un raccourci pour `<?php echo $variable; ?>`, très utilisé quand on mélange PHP et HTML.

## ✅ Points clés à retenir

- `GET` pour des données visibles/légères (recherche, filtres), `POST` pour des données sensibles ou volumineuses.
- Toujours utiliser `?? valeurParDefaut` pour accéder à `$_GET`/`$_POST`.
- Ne jamais faire confiance à une donnée utilisateur : toujours la valider avant utilisation.
- Toujours passer par `htmlspecialchars()` avant de réafficher une donnée utilisateur en HTML.
- `filter_var($valeur, FILTER_VALIDATE_EMAIL)` pour valider un email.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/reserved.variables.post.php](https://www.php.net/manual/fr/reserved.variables.post.php)
- [Niveau 02.6 — Sécurité web fondamentale](../../02-php-intermediaire/06-securite-web-fondamentaux/README.md) (XSS, CSRF, injections SQL en détail)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.6 — Chaînes de caractères et regex](../06-chaines-de-caracteres/README.md) · **Suite :** [01.8 — Fichiers, includes et organisation](../08-fichiers-et-includes/README.md)
