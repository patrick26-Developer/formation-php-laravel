# 09.5 — Versioning et documentation OpenAPI/Swagger

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre les stratégies de versioning d'une API.
- Documenter une API avec la spécification OpenAPI.
- Générer une documentation interactive avec Swagger UI.
- Maintenir une documentation synchronisée avec le code.

## 📋 Prérequis

[09.1 — Conception d'API RESTful](../01-conception-api-restful-bonnes-pratiques/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Pourquoi versionner une API ?

Une fois qu'une application mobile publiée ou un partenaire externe consomme votre API, vous ne pouvez plus **jamais** changer la structure d'une réponse existante sans casser leur intégration. Le versioning permet de faire évoluer l'API en introduisant une **nouvelle version** en parallèle, sans casser l'ancienne.

### Stratégies de versioning

```php
// 1. Versioning par préfixe d'URL (le plus courant, déjà vu au module 09.1)
Route::prefix('v1')->group(fn () => Route::apiResource('annonces', V1\AnnonceController::class));
Route::prefix('v2')->group(fn () => Route::apiResource('annonces', V2\AnnonceController::class));

// 2. Versioning par en-tête HTTP (moins visible dans l'URL, plus "pur" au sens REST)
// Accept: application/vnd.monapp.v2+json
```

> 📌 Le versioning par préfixe d'URL (`/api/v1/...`) est **largement dominant en pratique**, malgré des débats théoriques sur la "pureté REST" — il est simple à comprendre, à tester avec `curl`, et à documenter.

### Documenter avec OpenAPI (Swagger)

**OpenAPI** est une spécification standard (format YAML/JSON) décrivant les endpoints d'une API : routes, paramètres, formats de requête/réponse, codes d'erreur possibles.

```bash
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

```php
/**
 * @OA\Get(
 *     path="/api/v1/annonces",
 *     summary="Lister les annonces actives",
 *     @OA\Parameter(name="recherche", in="query", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="Liste paginée des annonces",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Annonce"))
 *         )
 *     )
 * )
 */
public function index(Request $request)
{
    // ...
}
```

```bash
php artisan l5-swagger:generate
```

Génère une documentation interactive accessible sur `/api/documentation`, où chaque endpoint peut être **testé directement depuis le navigateur**.

> 💡 L'intérêt majeur d'une documentation générée depuis des annotations dans le code (plutôt qu'un document séparé maintenu à la main) : elle a beaucoup moins de chances de devenir **obsolète**, puisqu'elle vit à côté du code qu'elle décrit et peut être régénérée à chaque déploiement.

### Documenter les codes d'erreur possibles

```php
/**
 * @OA\Response(response=404, description="Annonce non trouvée"),
 * @OA\Response(response=422, description="Erreur de validation"),
 * @OA\Response(response=429, description="Trop de requêtes (rate limiting, module 09.6)")
 */
```

> 📌 Une bonne documentation d'API liste systématiquement **les cas d'erreur**, pas seulement le cas de succès — c'est souvent l'information la plus utile pour un développeur tiers intégrant votre API pour la première fois.

## ✅ Points clés à retenir

- Versionner une API (généralement par préfixe d'URL `/api/v1/`) protège les clients existants d'un changement incompatible.
- OpenAPI/Swagger génère une documentation interactive testable directement, à partir d'annotations dans le code.
- Une documentation vivant à côté du code (générée, pas écrite séparément) reste synchronisée plus facilement.
- Toujours documenter les codes d'erreur possibles, pas seulement le cas nominal.

## ➡️ Pour aller plus loin

- [swagger.io/specification/](https://swagger.io/specification/)
- [github.com/DarkaOnLine/L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [09.4 — OAuth2 avec Passport](../04-authentification-api-passport-oauth2/README.md) · **Suite :** [09.6 — Rate limiting et sécurité des API](../06-rate-limiting-securite-api/README.md)
