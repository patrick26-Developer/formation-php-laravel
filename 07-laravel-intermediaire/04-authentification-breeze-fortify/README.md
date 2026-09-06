# 07.4 — Authentification avec Breeze/Fortify

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Installer et comprendre Laravel Breeze.
- Comprendre ce que Breeze génère (routes, contrôleurs, vues).
- Protéger des routes avec le middleware `auth`.
- Comprendre l'alternative Fortify (headless) et quand la choisir.

## 📋 Prérequis

[07.3 — Middlewares et Form Requests](../03-middlewares-form-requests/README.md), [02.5 — Sessions, cookies, authentification maison](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Ce que vous avez déjà construit à la main

Au [module 02.5](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.md) et au [mini-projet du niveau 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md), vous avez construit : hachage de mot de passe (`password_hash`/`password_verify`), gestion de session (`$_SESSION`), protection CSRF, middleware `exigerConnexion()`. **Breeze automatise l'intégralité de ce système**, avec une interface complète (inscription, connexion, mot de passe oublié, vérification d'email).

### Installer Laravel Breeze

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade    # génère les vues avec Blade (ou "react"/"vue"/"api" selon le besoin)
npm install && npm run build
php artisan migrate
```

Breeze génère :
- Des routes d'authentification (`routes/auth.php`) : inscription, connexion, déconnexion, mot de passe oublié, vérification d'email.
- Des contrôleurs (`app/Http/Controllers/Auth/`) implémentant toute cette logique.
- Des vues Blade prêtes à l'emploi (formulaires de connexion/inscription stylés avec Tailwind).
- Une migration `users` déjà présente par défaut dans Laravel (`name`, `email`, `password`).

> 📌 Comparez `app/Http/Controllers/Auth/AuthenticatedSessionController.php` généré par Breeze avec votre `Auth.php` du [mini-projet du niveau 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md) : vous y retrouverez `password_verify`, `session()->regenerate()` (l'équivalent de `session_regenerate_id(true)`, contre la fixation de session) — les mêmes principes, dans du code généré et testé par la communauté Laravel plutôt qu'écrit à la main.

### Le modèle `User` par défaut

```php
// app/Models/User.php
class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token']; // jamais sérialisés en JSON (module 09)

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // hache AUTOMATIQUEMENT à l'assignation, plus besoin de Hash::make() manuel
        ];
    }
}
```

> 💡 `'password' => 'hashed'` (Laravel 10+) applique `password_hash()` automatiquement dès que vous assignez `$user->password = 'texte en clair'` — vous n'avez **jamais** à appeler `Hash::make()` vous-même dans ce cas, réduisant le risque d'oublier de hacher un mot de passe.

### Protéger des routes

```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::resource('taches', TacheController::class);
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
});
```

> 📌 `middleware('auth')` est l'automatisation directe de `Auth::exigerConnexion()` — un seul mot-clé remplace la vérification manuelle `if (!isset($_SESSION['utilisateur_id'])) { header('Location: connexion.php'); exit; }` répétée en haut de chaque page protégée.

### Accéder à l'utilisateur connecté

```php
// Dans un contrôleur
$request->user();
auth()->user();

// Dans une vue Blade
{{ auth()->user()->name }}

@auth
    <p>Connecté en tant que {{ auth()->user()->name }}</p>
@else
    <a href="{{ route('login') }}">Se connecter</a>
@endauth
```

### Breeze vs Fortify : quand choisir quoi ?

| | Breeze | Fortify |
|---|---|---|
| Vues incluses | Oui (Blade, React, Vue) | Non — **headless**, vous créez vos propres vues |
| Cas d'usage typique | Démarrer vite avec une UI complète | Une UI déjà existante/sur-mesure, ou une SPA totalement personnalisée |
| Personnalisation | Modifier le code généré directement | Configurer via `config/fortify.php`, sans imposer de vue |

> 📌 Pour cette formation et la plupart des projets qui démarrent une UI depuis zéro, **Breeze est le choix recommandé** : la personnalisation du code généré est simple, et vous gardez un contrôle total puisque le code vous appartient après génération (contrairement à un package qui resterait une boîte noire).

## ✅ Points clés à retenir

- Breeze génère un système d'authentification complet et éprouvé, automatisant tout ce que vous avez construit à la main au niveau 02.
- `'password' => 'hashed'` remplace l'appel manuel à `password_hash()`.
- `middleware('auth')` protège une route en une déclaration, remplaçant un contrôle manuel répété.
- Breeze fournit des vues prêtes ; Fortify est headless, pour une UI entièrement personnalisée.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Starter Kits](https://laravel.com/docs/starter-kits)
- [laravel.com/docs — Fortify](https://laravel.com/docs/fortify)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [07.3 — Middlewares et Form Requests](../03-middlewares-form-requests/README.md) · **Suite :** [07.5 — Autorisations : Policies et Gates](../05-autorisations-policies-gates/README.md)
