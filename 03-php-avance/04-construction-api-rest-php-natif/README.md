# 03.4 — Construction d'une API REST en PHP natif

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre les principes REST (ressources, verbes HTTP, codes de statut).
- Construire des endpoints JSON en PHP natif.
- Lire un corps de requête JSON et répondre au bon format.
- Gérer proprement les erreurs d'une API.

## 📋 Prérequis

[03.2 — Architecture MVC from scratch](../02-architecture-mvc-from-scratch/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Qu'est-ce qu'une API REST ?

Une **API** (Application Programming Interface) permet à des programmes de communiquer entre eux, typiquement en échangeant des données au format **JSON**. **REST** (REpresentational State Transfer) est un ensemble de conventions pour organiser cette communication autour de **ressources** (des entités : `utilisateurs`, `taches`...) manipulées via les **verbes HTTP** standards.

| Verbe HTTP | Action | Exemple |
|---|---|---|
| `GET` | Lire une ou plusieurs ressources | `GET /taches` (liste), `GET /taches/5` (une tâche) |
| `POST` | Créer une ressource | `POST /taches` |
| `PUT`/`PATCH` | Modifier une ressource (entièrement / partiellement) | `PUT /taches/5` |
| `DELETE` | Supprimer une ressource | `DELETE /taches/5` |

### Les codes de statut HTTP essentiels

| Code | Signification | Exemple d'usage |
|---|---|---|
| `200 OK` | Succès | Une lecture ou modification réussie |
| `201 Created` | Ressource créée avec succès | Après un `POST` réussi |
| `204 No Content` | Succès, sans contenu à retourner | Après un `DELETE` réussi |
| `400 Bad Request` | Requête mal formée (données invalides) | Un champ obligatoire manquant |
| `401 Unauthorized` | Authentification requise ou invalide | Jeton d'API absent ou incorrect |
| `403 Forbidden` | Authentifié, mais sans les droits nécessaires | Un utilisateur essaie de modifier les données d'un autre |
| `404 Not Found` | Ressource inexistante | `GET /taches/9999` alors que la tâche 9999 n'existe pas |
| `422 Unprocessable Entity` | Données valides en format, mais invalides métier | Un email déjà utilisé à l'inscription |
| `500 Internal Server Error` | Erreur inattendue côté serveur | Une exception non gérée |

### Répondre en JSON

```php
<?php
declare(strict_types=1);

function repondreJson(mixed $donnees, int $codeStatut = 200): never {
    http_response_code($codeStatut);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($donnees, JSON_UNESCAPED_UNICODE);
    exit;
}

// Utilisation :
repondreJson(['message' => 'Tâche créée'], 201);
repondreJson(['erreur' => 'Tâche non trouvée'], 404);
```

> 📌 `JSON_UNESCAPED_UNICODE` évite que les accents (`é`, `à`...) soient transformés en séquences `é` illisibles dans la réponse JSON.

### Lire un corps de requête JSON

Contrairement à un formulaire HTML classique, une API reçoit généralement son corps de requête au format JSON brut, pas dans `$_POST`.

```php
<?php
declare(strict_types=1);

function lireCorpsJson(): array {
    $corpsBrut = file_get_contents('php://input');
    $donnees = json_decode($corpsBrut, true);

    if (!is_array($donnees)) {
        repondreJson(['erreur' => 'Corps de requête JSON invalide.'], 400);
    }

    return $donnees;
}
```

### Un endpoint complet

```php
<?php
declare(strict_types=1);

// POST /api/taches
require_once __DIR__ . '/TacheRepository.php';

$donnees = lireCorpsJson();

if (empty($donnees['titre'])) {
    repondreJson(['erreur' => 'Le champ "titre" est requis.'], 400);
}

$repository = new TacheRepository($pdo);
$id = $repository->creer($donnees['titre'], $donnees['description'] ?? '');

repondreJson(['id' => $id, 'message' => 'Tâche créée avec succès.'], 201);
```

```php
<?php
declare(strict_types=1);

// GET /api/taches/{id}
$tache = $repository->trouver((int) $_GET['id']);

if ($tache === null) {
    repondreJson(['erreur' => 'Tâche non trouvée.'], 404);
}

repondreJson($tache, 200);
```

### Structurer les réponses de façon cohérente

Une bonne pratique : adopter une structure de réponse homogène dans toute l'API, par exemple :

```php
<?php
// Succès
['succes' => true, 'donnees' => [...]]

// Erreur
['succes' => false, 'erreur' => "Message d'erreur explicite"]
```

> 📌 Ce sujet est repris en détail (structuration avec des classes dédiées, pagination standardisée) au [module 09.2 — API Resources et transformation des données](../../09-api-rest-laravel/02-api-resources-transformers/README.md), où Laravel automatise cette cohérence.

### Gérer les erreurs proprement dans une API

```php
<?php
declare(strict_types=1);

try {
    $tache = $repository->trouver($id);

    if ($tache === null) {
        repondreJson(['succes' => false, 'erreur' => 'Tâche non trouvée.'], 404);
    }

    repondreJson(['succes' => true, 'donnees' => $tache], 200);
} catch (PDOException $e) {
    // On ne renvoie JAMAIS le détail technique ($e->getMessage()) au client :
    // il pourrait révéler la structure de la base de données à un attaquant.
    error_log($e->getMessage()); // on log l'erreur réelle côté serveur
    repondreJson(['succes' => false, 'erreur' => 'Une erreur interne est survenue.'], 500);
}
```

## ✅ Points clés à retenir

- REST organise une API autour de ressources et des verbes HTTP standards (`GET`, `POST`, `PUT`/`PATCH`, `DELETE`).
- Les codes de statut HTTP communiquent le résultat de la requête, pas seulement le corps de la réponse.
- Le corps d'une requête API JSON se lit via `file_get_contents('php://input')`, pas `$_POST`.
- Ne jamais exposer le détail technique d'une erreur serveur (message d'exception SQL...) dans la réponse envoyée au client.

## ➡️ Pour aller plus loin

- [restfulapi.net](https://restfulapi.net/) — référence sur les principes REST
- [Niveau 09 — API REST avec Laravel](../../09-api-rest-laravel/README.md) (comment Laravel automatise tout ceci)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [03.3 — Tests unitaires avec PHPUnit](../03-tests-unitaires-phpunit/README.md) · **Suite :** [03.5 — Bonnes pratiques, PSR-12, Clean Code](../05-bonnes-pratiques-psr-clean-code/README.md)
