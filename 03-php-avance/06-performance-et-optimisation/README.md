# 03.6 — Performance et optimisation PHP

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre l'intérêt d'OPcache.
- Identifier les erreurs de performance les plus courantes en PHP.
- Mesurer le temps d'exécution et la mémoire utilisée par un script.
- Optimiser des requêtes et boucles courantes.

## 📋 Prérequis

[03.5 — Bonnes pratiques, PSR-12, Clean Code](../05-bonnes-pratiques-psr-clean-code/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

> ⚠️ Règle d'or de l'optimisation : **mesurer avant d'optimiser**. Une optimisation appliquée sans mesure préalable est souvent une perte de temps, voire une dégradation de la lisibilité pour un gain de performance nul ou négligeable.

### Mesurer le temps et la mémoire

```php
<?php
$debut = microtime(true);
$memoireDebut = memory_get_usage();

// ... code à mesurer ...
for ($i = 0; $i < 1_000_000; $i++) {
    $carre = $i ** 2;
}

$duree = microtime(true) - $debut;
$memoireUtilisee = memory_get_usage() - $memoireDebut;

echo "Durée : " . round($duree * 1000, 2) . " ms\n";
echo "Mémoire : " . round($memoireUtilisee / 1024, 2) . " Ko\n";
```

### OPcache : accélérer l'exécution en production

Par défaut, PHP **recompile** chaque script à chaque requête (l'interprétation du code source en bytecode). **OPcache** met ce bytecode en cache en mémoire, évitant cette recompilation à chaque requête — un gain de performance très significatif en production.

```ini
; Dans php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0 ; en production : ne vérifie pas les fichiers modifiés à chaque requête (nécessite un redémarrage/reset du cache après un déploiement)
```

> ⚠️ `opcache.validate_timestamps=0` est un piège classique en développement : si activé, vos modifications de code ne seraient jamais prises en compte sans vider le cache manuellement. À réserver à la production, avec un processus de déploiement qui vide le cache OPcache à chaque nouvelle version.

### Erreurs de performance courantes

**1. Requêtes SQL dans une boucle (le problème "N+1")**

```php
<?php
// ❌ Une requête SQL PAR tâche : 1 requête pour la liste + N requêtes supplémentaires
$taches = $pdo->query("SELECT * FROM taches")->fetchAll();
foreach ($taches as $tache) {
    $utilisateur = $pdo->query("SELECT * FROM utilisateurs WHERE id = " . $tache['utilisateur_id'])->fetch();
    echo $utilisateur['nom'];
}

// ✅ Une seule requête supplémentaire, avec une jointure ou un IN (...)
$taches = $pdo->query(
    "SELECT taches.*, utilisateurs.nom FROM taches
     JOIN utilisateurs ON utilisateurs.id = taches.utilisateur_id"
)->fetchAll();
```

> 📌 Ce problème, appelé **problème N+1**, est extrêmement courant — y compris (surtout !) avec Eloquent dans Laravel si l'on n'utilise pas l'*eager loading* (`with()`, vu au [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md)). Le reconnaître maintenant en PHP natif vous permettra de le repérer immédiatement dans Laravel.

**2. Concaténation de chaînes en boucle sur de très gros volumes**

```php
<?php
// Peu efficace sur un très grand nombre d'itérations
$resultat = '';
foreach ($millionsDeLignes as $ligne) {
    $resultat .= $ligne . "\n";
}

// Plus efficace : accumuler dans un tableau, joindre une seule fois à la fin
$lignes = [];
foreach ($millionsDeLignes as $ligne) {
    $lignes[] = $ligne;
}
$resultat = implode("\n", $lignes);
```

**3. Charger toutes les données en mémoire alors qu'on n'a besoin que d'un sous-ensemble**

```php
<?php
// ❌ Charge TOUS les utilisateurs en mémoire pour n'en afficher que 10
$tousLesUtilisateurs = $pdo->query("SELECT * FROM utilisateurs")->fetchAll();
$dixPremiers = array_slice($tousLesUtilisateurs, 0, 10);

// ✅ Ne demande que ce dont on a besoin, directement à la base de données
$dixPremiers = $pdo->query("SELECT * FROM utilisateurs LIMIT 10")->fetchAll();
```

### `isset()` plutôt que `array_key_exists()` quand c'est suffisant

```php
<?php
// isset() est légèrement plus rapide, mais retourne false si la valeur est null
isset($tableau['cle']);

// array_key_exists() vérifie la présence de la clé, même si sa valeur est null
array_key_exists('cle', $tableau);
```

Pour la plupart des cas (vérifier qu'une donnée existe et n'est pas vide), `isset()` suffit et se lit tout aussi bien.

## ✅ Points clés à retenir

- Toujours mesurer avant d'optimiser : une intuition sur "ce qui est lent" est souvent fausse.
- OPcache doit être activé en production, avec `validate_timestamps=0` et un cache vidé à chaque déploiement.
- Le problème N+1 (une requête par élément d'une liste, dans une boucle) est l'erreur de performance la plus fréquente et la plus coûteuse.
- Ne chargez en mémoire que les données réellement nécessaires (`LIMIT`, pagination du module 02.9).

## ➡️ Pour aller plus loin

- [php.net/manual/fr/book.opcache.php](https://www.php.net/manual/fr/book.opcache.php)
- [Module 08.2 — Cache et optimisation de performance (Laravel)](../../08-laravel-avance/02-cache-optimisation-performance/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [03.5 — Bonnes pratiques, PSR-12, Clean Code](../05-bonnes-pratiques-psr-clean-code/README.md) · **Suite :** [Grand projet : Mini-framework MVC avec API](../grand-projet-01-mini-framework-mvc-avec-api/README.md)
