# 08.4 — Service Providers et packages personnalisés

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le rôle des Service Providers dans le cycle de démarrage de Laravel.
- Utiliser le Service Container pour l'injection de dépendances.
- Lier une interface à une implémentation.
- Structurer un package Laravel réutilisable.

## 📋 Prérequis

[08.3 — Tests avec Pest et PHPUnit dans Laravel](../03-tests-pest-phpunit-laravel/README.md), [02.2 — Héritage, interfaces, abstraction](../../02-php-intermediaire/02-poo-heritage-interfaces-abstraction/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Le Service Container : l'injection de dépendances automatisée

Depuis le début de cette formation Laravel, vous avez écrit des méthodes comme `public function __construct(private TacheRepository $taches)` sans jamais instancier `TacheRepository` vous-même dans un contrôleur. C'est le **Service Container** de Laravel qui résout automatiquement ces dépendances.

```php
class ArticleController extends Controller
{
    public function index(ArticleRepository $repository) // Laravel instancie et injecte automatiquement
    {
        return view('articles.index', ['articles' => $repository->tous()]);
    }
}
```

> 💡 Reconnaissez l'**injection de dépendances** évoquée au [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md) (principe SOLID "Dependency Inversion") : plutôt que le contrôleur crée lui-même `new ArticleRepository()`, il **déclare** en avoir besoin, et Laravel le lui fournit — exactement comme `InscriptionService` recevait un `ServiceEmail` en paramètre de constructeur au lieu de l'instancier lui-même.

### Lier une interface à une implémentation

```php
// app/Contracts/PaiementGateway.php
interface PaiementGateway
{
    public function payer(float $montant): bool;
}

// app/Services/StripeGateway.php
class StripeGateway implements PaiementGateway
{
    public function payer(float $montant): bool { /* ... */ return true; }
}
```

```php
// app/Providers/AppServiceProvider.php
public function register(): void
{
    $this->app->bind(PaiementGateway::class, StripeGateway::class);
}
```

```php
// N'importe quel contrôleur peut maintenant demander l'INTERFACE
class CommandeController extends Controller
{
    public function payer(PaiementGateway $gateway) // Laravel injecte StripeGateway automatiquement
    {
        $gateway->payer(49.99);
    }
}
```

> 💡 C'est le pattern **Strategy** du [module 03.1](../../03-php-avance/01-design-patterns-php/README.md), combiné au principe d'inversion de dépendance : pour passer à un autre prestataire de paiement demain (`PaypalGateway`), **une seule ligne change** (`$this->app->bind(...)`), aucun contrôleur n'a besoin d'être modifié.

### Les Service Providers : le point d'entrée du démarrage de l'application

```php
// app/Providers/AppServiceProvider.php
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Enregistrer des liaisons (bind), comme ci-dessus
    }

    public function boot(): void
    {
        // Code exécuté une fois TOUS les services enregistrés
        // (Gates du module 07.5, écouteurs d'événements globaux, etc.)
    }
}
```

> 📌 Vous avez déjà utilisé `boot()` pour enregistrer un Gate au [module 07.5](../../07-laravel-intermediaire/05-autorisations-policies-gates/README.md) : c'est l'endroit conventionnel où Laravel attend ce type de configuration globale, exécutée à chaque démarrage de l'application.

### Structurer un package personnalisé (aperçu)

Pour un composant destiné à être réutilisé entre plusieurs projets (par exemple, un système de commentaires générique), Laravel permet de le structurer en package :

```
packages/mon-org/commentaires/
├── composer.json                  # déclare le package comme dépendance locale
├── src/
│   ├── CommentairesServiceProvider.php
│   └── Models/Commentaire.php
└── routes/web.php
```

```json
// composer.json du projet principal
{
    "repositories": [{"type": "path", "url": "packages/mon-org/commentaires"}],
    "require": {"mon-org/commentaires": "*"}
}
```

> 📌 Ce sujet est volontairement gardé en aperçu : extraire un package complet est une compétence avancée, rarement nécessaire avant d'avoir constaté un besoin réel de réutilisation entre **plusieurs** projets distincts. Sur-packager prématurément est un anti-pattern (rappel du principe YAGNI, "You Aren't Gonna Need It").

## ✅ Points clés à retenir

- Le Service Container résout automatiquement les dépendances déclarées en paramètre de constructeur.
- Lier une interface à une implémentation (`$this->app->bind()`) permet de changer d'implémentation sans toucher aux contrôleurs qui la consomment.
- `register()` enregistre des liaisons ; `boot()` exécute du code une fois tous les services disponibles.
- Un package Laravel structure du code réutilisable entre plusieurs projets — à ne pas sur-utiliser prématurément.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Service Container](https://laravel.com/docs/container)
- [laravel.com/docs — Service Providers](https://laravel.com/docs/providers)
- [laravel.com/docs — Package Development](https://laravel.com/docs/packages)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [08.3 — Tests avec Pest et PHPUnit](../03-tests-pest-phpunit-laravel/README.md) · **Suite :** [08.5 — Architecture modulaire et multi-tenancy](../05-architecture-modulaire/README.md)
