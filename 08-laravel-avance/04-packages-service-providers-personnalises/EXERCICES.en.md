# Exercises — 08.4 Service Providers and Custom Packages

## Exercise 1 — Injection into a controller (easy)

Create a `StatistiquesService` class with a method `nombreAnnoncesActives(): int`. Inject it into a controller via its constructor, without ever instantiating it with `new`.

## Exercise 2 — Interface and implementation (easy)

Create an `Horodateur` interface with `maintenant(): string`, and an implementation `HorodateurSysteme` using `now()`. Bind them in `AppServiceProvider::register()`.

## Exercise 3 — Switching implementation without touching the controller (medium)

Create a second implementation, `HorodateurFige`, always returning the same date (useful for tests). Change only the `bind()` line to switch from one implementation to the other, without modifying the controller that uses it.

## Exercise 4 — Singleton in the Service Container (medium)

Use `$this->app->singleton()` instead of `bind()` for a `CompteurRequetes` class (incremented on every resolution). Verify that two different injections within the same HTTP request correctly share the same instance (unlike `bind()`, which would create a new one every time).

## Exercise 5 — Manually binding a Policy (hard)

[Module 07.5](../../07-laravel-intermediaire/05-autorisations-policies-gates/README.en.md) mentioned Policy auto-discovery. In a case where the naming doesn't follow the convention (`Annonce` → `GestionAnnoncePolicy` instead of `AnnoncePolicy`), register the binding manually in `AppServiceProvider::boot()` with `Gate::policy(Annonce::class, GestionAnnoncePolicy::class)`, and verify `$this->authorize()` still works.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
