# 01.6 — Chaînes de caractères et expressions régulières

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Manipuler des chaînes avec les fonctions natives essentielles.
- Formater et transformer du texte.
- Utiliser les expressions régulières de base (`preg_match`, `preg_replace`).

## 📋 Prérequis

[01.5 — Tableaux](../05-tableaux/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Fonctions de base sur les chaînes

```php
<?php
$texte = "Bonjour le monde";

strlen($texte);            // 17 : longueur en octets
strtoupper($texte);        // "BONJOUR LE MONDE"
strtolower($texte);        // "bonjour le monde"
ucfirst("bonjour");        // "Bonjour" : met la première lettre en majuscule
ucwords("bonjour le monde"); // "Bonjour Le Monde" : majuscule à chaque mot

str_contains($texte, "monde");  // true (PHP 8+)
str_starts_with($texte, "Bon"); // true (PHP 8+)
str_ends_with($texte, "monde"); // true (PHP 8+)

substr($texte, 0, 7);      // "Bonjour" : sous-chaîne (début, longueur)
str_replace("monde", "PHP", $texte); // "Bonjour le PHP"

trim("  espaces autour  "); // "espaces autour" : retire les espaces en début/fin
```

> 📌 Avant PHP 8, il fallait utiliser `strpos($texte, "monde") !== false` pour tester une présence. `str_contains()` est plus lisible et évite un piège classique (`strpos` peut retourner `0`, qui est "falsy" mais signifie pourtant "trouvé en position 0").

### Découper et assembler

```php
<?php
$phrase = "pomme,banane,cerise";

$fruits = explode(",", $phrase); // ["pomme", "banane", "cerise"]
$rejoint = implode(" - ", $fruits); // "pomme - banane - cerise"
```

### Interpolation et formatage avancé

```php
<?php
$nom = "Alice";
$age = 28;

// sprintf : formatage précis, notamment pour aligner des nombres
$phrase = sprintf("%s a %d ans", $nom, $age);
$prixFormate = sprintf("%.2f €", 19.5); // "19.50 €"

// Syntaxe "heredoc" : pour des blocs de texte longs avec interpolation
$message = <<<TEXTE
Bonjour $nom,
Vous avez $age ans.
TEXTE;
```

### Expressions régulières (regex) avec PCRE

PHP utilise la syntaxe PCRE (Perl Compatible Regular Expressions), délimitée par un caractère (généralement `/`) :

```php
<?php
$email = "alice@example.com";

// preg_match : teste si le motif correspond, retourne 1 (trouvé) ou 0
if (preg_match('/^[\w.+-]+@[\w-]+\.[a-z]{2,}$/i', $email)) {
    echo "Email valide (format)";
}

// preg_replace : remplace toutes les occurrences correspondant au motif
$texteNettoye = preg_replace('/[0-9]/', '', "Code2024Postal"); // "CodePostal"

// preg_match_all : capture toutes les correspondances
preg_match_all('/\d+/', "J'ai 3 chats et 12 poissons", $nombres);
print_r($nombres[0]); // ["3", "12"]
```

> ⚠️ Une regex vérifie un **format**, pas une validité réelle. `preg_match` sur un email vérifie que la chaîne *ressemble* à un email, mais ne garantit pas qu'il existe. Pour une vraie validation d'email en PHP, on utilise plutôt `filter_var($email, FILTER_VALIDATE_EMAIL)` (vu au [module 01.7](../07-formulaires-http-get-post/README.md)).

## ✅ Points clés à retenir

- `str_contains`, `str_starts_with`, `str_ends_with` (PHP 8+) sont plus lisibles que `strpos`.
- `explode`/`implode` pour passer d'une chaîne à un tableau et inversement.
- `sprintf` pour un formatage précis (arrondis, alignement).
- Les regex servent à vérifier des **formats** ; `filter_var` est souvent préférable pour valider de vraies données (email, URL...).

## ➡️ Pour aller plus loin

- [php.net/manual/fr/ref.strings.php](https://www.php.net/manual/fr/ref.strings.php)
- [regex101.com](https://regex101.com) — tester ses expressions régulières interactivement (choisir le flavor "PCRE2")

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.5 — Tableaux](../05-tableaux/README.md) · **Suite :** [01.7 — Formulaires HTML et GET/POST](../07-formulaires-http-get-post/README.md)
