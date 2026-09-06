# 09.4 — Authentification OAuth2 avec Passport

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le protocole OAuth2 et ses cas d'usage.
- Distinguer les différents "grant types" et quand les utiliser.
- Installer et configurer Passport pour une application cliente tierce.
- Savoir quand préférer Passport à Sanctum.

## 📋 Prérequis

[09.3 — Authentification API avec Sanctum](../03-authentification-api-sanctum/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### OAuth2 : autoriser un tiers sans partager de mot de passe

**OAuth2** est un protocole standard permettant à une application tierce d'accéder à des ressources **au nom d'un utilisateur**, sans jamais connaître son mot de passe. Exemple classique : "Se connecter avec Google" sur un site tiers — le site n'obtient jamais votre mot de passe Google, seulement un jeton limité à certaines permissions (votre email, votre nom).

### Sanctum vs Passport : quand choisir quoi ?

| | Sanctum (module 09.3) | Passport |
|---|---|---|
| Complexité | Simple, jetons personnels ou cookies SPA | Protocole OAuth2 complet |
| Cas d'usage typique | **Votre propre** application mobile/SPA consommant **votre propre** API | Autoriser des applications **tierces** (développées par d'autres) à accéder à votre API au nom d'un utilisateur |
| Exemple concret | L'app mobile officielle de votre plateforme d'annonces | Un partenaire qui construit son propre outil s'intégrant à votre plateforme, avec l'autorisation de vos utilisateurs |

> ⚠️ **Règle pratique largement partagée dans l'écosystème Laravel** : si vous ne développez **que** votre propre client (app mobile officielle, SPA du même produit), Sanctum suffit **presque toujours** et est bien plus simple à opérer. Passport se justifie uniquement quand des **applications tierces, développées par d'autres équipes**, doivent s'authentifier au nom de vos utilisateurs — un besoin réel mais minoritaire.

### Installer Passport

```bash
composer require laravel/passport
php artisan migrate
php artisan passport:install
```

```php
// app/Models/User.php
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
}
```

### Les principaux "grant types" (façons d'obtenir un jeton)

| Grant type | Cas d'usage |
|---|---|
| **Authorization Code** | Application tierce avec une interface web/mobile, redirigeant l'utilisateur vers une page de connexion/consentement |
| **Client Credentials** | Communication machine-à-machine, sans utilisateur impliqué (un service backend qui interroge votre API) |
| **Password Grant** | *(Déconseillé)* l'application tierce demande directement email/mot de passe — ne devrait être utilisé que pour vos **propres** clients de confiance absolue |

```php
// Exemple : Client Credentials (machine-à-machine)
Route::middleware('client')->get('/api/statistiques-globales', function () {
    return response()->json(['total_annonces' => Annonce::count()]);
});
```

### Le flux Authorization Code, simplifié

1. L'application tierce redirige l'utilisateur vers `/oauth/authorize?client_id=...&scope=annonces:lire`.
2. L'utilisateur se connecte (sur **votre** plateforme) et **consent explicitement** à autoriser cette application pour les permissions demandées.
3. Votre serveur redirige vers l'application tierce avec un code temporaire.
4. L'application tierce échange ce code contre un jeton d'accès, en backend (jamais exposé au navigateur).

> 📌 Ce flux est délibérément plus complexe que Sanctum : il existe précisément pour permettre à un utilisateur de **consentir explicitement** et de **révoquer** l'accès d'une application tierce sans jamais avoir partagé son mot de passe avec elle.

## ✅ Points clés à retenir

- OAuth2 permet à un tiers d'accéder à des ressources au nom d'un utilisateur, sans partage de mot de passe.
- Sanctum convient à vos propres clients (mobile officiel, SPA) ; Passport se justifie pour de vraies applications tierces.
- Le grant "Authorization Code" implique un consentement explicite de l'utilisateur ; "Client Credentials" convient au machine-à-machine.
- Ne pas sur-équiper une API avec Passport si Sanctum suffit au besoin réel — la complexité doit être justifiée.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Passport](https://laravel.com/docs/passport)
- [oauth.net/2/](https://oauth.net/2/) — spécification OAuth2

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [09.3 — Sanctum](../03-authentification-api-sanctum/README.md) · **Suite :** [09.5 — Versioning et documentation OpenAPI](../05-versioning-documentation-openapi/README.md)
