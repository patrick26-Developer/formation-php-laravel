# 08.4 — Service Providers and Custom Packages

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the role of Service Providers in Laravel's boot cycle.
- Use the Service Container for dependency injection.
- Bind an interface to an implementation.
- Structure a reusable Laravel package.

## 📋 Prerequisites

[08.3 — Testing with Pest and PHPUnit in Laravel](../03-tests-pest-phpunit-laravel/README.en.md), [02.2 — Inheritance, Interfaces, Abstraction](../../02-php-intermediaire/02-poo-heritage-interfaces-abstraction/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### The Service Container: automated dependency injection

Since the start of this Laravel training, you've written methods like `public function __construct(private TacheRepository $taches)` without ever instantiating `TacheRepository` yourself in a controller. This is Laravel's **Service Container** automatically resolving these dependencies.

```php
class ArticleController extends Controller
{
    public function index(ArticleRepository $repository) // Laravel instantiates and injects it automatically
    {
        return view('articles.index', ['articles' => $repository->tous()]);
    }
}
```

> 💡 Recognize the **dependency injection** mentioned in [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.en.md) (the SOLID "Dependency Inversion" principle): rather than the controller creating `new ArticleRepository()` itself, it **declares** that it needs one, and Laravel supplies it — exactly like `InscriptionService` received a `ServiceEmail` as a constructor parameter instead of instantiating it itself.

### Binding an interface to an implementation

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
// Any controller can now ask for the INTERFACE
class CommandeController extends Controller
{
    public function payer(PaiementGateway $gateway) // Laravel injects StripeGateway automatically
    {
        $gateway->payer(49.99);
    }
}
```

> 💡 This is the **Strategy** pattern from [module 03.1](../../03-php-avance/01-design-patterns-php/README.en.md), combined with the dependency inversion principle: to switch to a different payment provider tomorrow (`PaypalGateway`), **only one line changes** (`$this->app->bind(...)`), no controller needs to be modified.

### Service Providers: the application's boot entry point

```php
// app/Providers/AppServiceProvider.php
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register bindings, as above
    }

    public function boot(): void
    {
        // Code executed once ALL services have been registered
        // (Gates from module 07.5, global event listeners, etc.)
    }
}
```

> 📌 You already used `boot()` to register a Gate in [module 07.5](../../07-laravel-intermediaire/05-autorisations-policies-gates/README.en.md): this is the conventional place where Laravel expects this kind of global configuration, executed on every application boot.

### Structuring a custom package (overview)

For a component meant to be reused across several projects (for example, a generic comments system), Laravel lets you structure it as a package:

```
packages/mon-org/commentaires/
├── composer.json                  # declares the package as a local dependency
├── src/
│   ├── CommentairesServiceProvider.php
│   └── Models/Commentaire.php
└── routes/web.php
```

```json
// composer.json of the main project
{
    "repositories": [{"type": "path", "url": "packages/mon-org/commentaires"}],
    "require": {"mon-org/commentaires": "*"}
}
```

> 📌 This topic is deliberately kept at overview level: extracting a full package is an advanced skill, rarely needed before you've observed a real need for reuse across **several** distinct projects. Over-packaging prematurely is an anti-pattern (a reminder of the YAGNI principle, "You Aren't Gonna Need It").

## ✅ Key takeaways

- The Service Container automatically resolves dependencies declared as constructor parameters.
- Binding an interface to an implementation (`$this->app->bind()`) lets you change implementation without touching the controllers that consume it.
- `register()` registers bindings; `boot()` runs code once all services are available.
- A Laravel package structures code for reuse across several projects — don't over-use it prematurely.

## ➡️ Going further

- [laravel.com/docs — Service Container](https://laravel.com/docs/container)
- [laravel.com/docs — Service Providers](https://laravel.com/docs/providers)
- [laravel.com/docs — Package Development](https://laravel.com/docs/packages)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [08.3 — Testing with Pest and PHPUnit](../03-tests-pest-phpunit-laravel/README.en.md) · **Next:** [08.5 — Modular Architecture and Multi-tenancy](../05-architecture-modulaire/README.en.md)
