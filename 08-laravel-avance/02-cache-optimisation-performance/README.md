# 08.2 — Cache et optimisation de performance

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Utiliser le système de cache Laravel pour éviter des calculs/requêtes coûteux répétés.
- Choisir une stratégie d'invalidation de cache appropriée.
- Mettre en cache des requêtes Eloquent et des vues.
- Utiliser les commandes d'optimisation Artisan pour la production.

## 📋 Prérequis

[08.1 — Jobs, Queues, Events, Listeners](../01-jobs-queues-events-listeners/README.md), [03.6 — Performance et optimisation PHP](../../03-php-avance/06-performance-et-optimisation/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Le cache : ne pas refaire un travail déjà fait récemment

```
# .env
CACHE_STORE=redis   # ou "file"/"database" en développement, "redis" recommandé en production
```

```php
use Illuminate\Support\Facades\Cache;

// Cache::remember() : calcule UNE FOIS, réutilise ensuite pendant la durée donnée
$categories = Cache::remember('categories.toutes', now()->addHours(6), function () {
    return Category::orderBy('nom')->get();
});
```

> 💡 `Cache::remember()` vérifie d'abord si la clé `'categories.toutes'` existe déjà en cache : si oui, retourne directement cette valeur (aucune requête SQL) ; sinon, exécute la fonction, stocke le résultat, puis le retourne. Un candidat idéal : des données qui changent rarement (catégories, configuration) mais sont lues à **chaque** requête.

### Invalider le cache au bon moment

```php
// Après une modification qui rend le cache obsolète
Cache::forget('categories.toutes');

// Ou directement au moment de la modification, dans un Model Event (module 07.6)
class Category extends Model
{
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('categories.toutes'));
        static::deleted(fn () => Cache::forget('categories.toutes'));
    }
}
```

> ⚠️ **Le vrai défi du cache n'est pas de le remplir, c'est de savoir quand l'invalider.** Un cache jamais invalidé sert des données périmées ; un cache invalidé trop souvent perd tout son intérêt. Toujours identifier explicitement **quel événement** doit vider **quelle clé**.

### Mettre en cache une requête coûteuse et paramétrée

```php
$statistiques = Cache::remember(
    "statistiques.utilisateur.{$user->id}",
    now()->addMinutes(30),
    fn () => [
        'total_annonces' => $user->annonces()->count(),
        'total_messages_recus' => Message::whereIn('annonce_id', $user->annonces()->pluck('id'))->count(),
    ]
);
```

> 📌 Une clé de cache **paramétrée** (incluant `$user->id`) est essentielle : sans cela, tous les utilisateurs partageraient la même entrée de cache, montrant les statistiques d'un autre utilisateur — un bug de sécurité potentiellement grave.

### Cache::tags() pour invalider un groupe de clés (drivers compatibles : Redis, Memcached)

```php
Cache::tags(['annonces'])->remember('annonces.actives', 3600, fn () => Annonce::actives()->get());

// Invalide TOUTES les clés associées à ce tag en une fois
Cache::tags(['annonces'])->flush();
```

### Optimiser pour la production avec Artisan

```bash
php artisan config:cache     # met en cache toute la configuration (voir le piège du module 06.1)
php artisan route:cache        # met en cache les routes, accélère leur résolution
php artisan view:cache           # pré-compile les vues Blade

php artisan optimize             # exécute les trois commandes ci-dessus en une fois
php artisan optimize:clear         # les annule toutes (à faire après chaque déploiement, AVANT de recacher)
```

> ⚠️ Un déploiement en production doit **toujours** suivre l'ordre : `optimize:clear` (vider les anciens caches) → déployer le nouveau code → `optimize` (recréer les caches à jour). Oublier cette étape après un déploiement peut laisser tourner d'anciennes routes ou une configuration obsolète — approfondi au [module 11.3](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md).

## ✅ Points clés à retenir

- `Cache::remember()` calcule une fois, réutilise pendant la durée spécifiée — idéal pour des données coûteuses et peu changeantes.
- Toujours identifier explicitement quel événement doit invalider quelle clé de cache.
- Une clé de cache doit être paramétrée par utilisateur/contexte quand la donnée en dépend, sous peine de fuite de données entre utilisateurs.
- `php artisan optimize`/`optimize:clear` encadrent chaque déploiement en production.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Cache](https://laravel.com/docs/cache)
- [Module 03.6 — Performance et optimisation PHP](../../03-php-avance/06-performance-et-optimisation/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [08.1 — Jobs, Queues, Events, Listeners](../01-jobs-queues-events-listeners/README.md) · **Suite :** [08.3 — Tests avec Pest et PHPUnit dans Laravel](../03-tests-pest-phpunit-laravel/README.md)
