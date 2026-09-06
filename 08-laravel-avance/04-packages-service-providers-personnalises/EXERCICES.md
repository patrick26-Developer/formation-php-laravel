# Exercices — 08.4 Service Providers et packages personnalisés

## Exercice 1 — Injection dans un contrôleur (facile)

Créez une classe `StatistiquesService` avec une méthode `nombreAnnoncesActives(): int`. Injectez-la dans un contrôleur via son constructeur, sans jamais l'instancier avec `new`.

## Exercice 2 — Interface et implémentation (facile)

Créez une interface `Horodateur` avec `maintenant(): string`, et une implémentation `HorodateurSysteme` utilisant `now()`. Liez-les dans `AppServiceProvider::register()`.

## Exercice 3 — Changer d'implémentation sans toucher au contrôleur (moyen)

Créez une seconde implémentation `HorodateurFige` retournant toujours la même date (utile pour les tests). Changez uniquement la ligne de `bind()` pour basculer d'une implémentation à l'autre, sans modifier le contrôleur qui l'utilise.

## Exercice 4 — Singleton dans le Service Container (moyen)

Utilisez `$this->app->singleton()` au lieu de `bind()` pour une classe `CompteurRequetes` (incrémentée à chaque résolution). Vérifiez que deux injections différentes dans la même requête HTTP partagent bien la même instance (contrairement à `bind()`, qui en créerait une nouvelle à chaque fois).

## Exercice 5 — Lier une Policy manuellement (difficile)

Le [module 07.5](../../07-laravel-intermediaire/05-autorisations-policies-gates/README.md) mentionnait l'auto-découverte des Policies. Dans un cas où le nommage ne suit pas la convention (`Annonce` → `GestionAnnoncePolicy` au lieu de `AnnoncePolicy`), enregistrez la liaison manuellement dans `AppServiceProvider::boot()` avec `Gate::policy(Annonce::class, GestionAnnoncePolicy::class)`, et vérifiez que `$this->authorize()` fonctionne toujours.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
