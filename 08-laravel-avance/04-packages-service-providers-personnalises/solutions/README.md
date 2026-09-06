# Solutions — 08.4 Service Providers et packages personnalisés

## Exercice 1

```php
class StatistiquesService
{
    public function nombreAnnoncesActives(): int
    {
        return Annonce::where('active', true)->count();
    }
}
```
```php
class TableauDeBordController extends Controller
{
    public function index(StatistiquesService $stats)
    {
        return view('dashboard', ['total' => $stats->nombreAnnoncesActives()]);
    }
}
```

## Exercice 2

```php
interface Horodateur { public function maintenant(): string; }

class HorodateurSysteme implements Horodateur
{
    public function maintenant(): string { return now()->toDateTimeString(); }
}
```
```php
// AppServiceProvider::register()
$this->app->bind(Horodateur::class, HorodateurSysteme::class);
```

## Exercice 3

```php
class HorodateurFige implements Horodateur
{
    public function maintenant(): string { return '2024-01-01 00:00:00'; }
}
```
```php
// Seule cette ligne change :
$this->app->bind(Horodateur::class, HorodateurFige::class);
```
Le contrôleur qui déclare `public function __construct(Horodateur $horodateur)`
n'est jamais modifié : il ne connaît que l'interface.

## Exercice 4

```php
// AppServiceProvider::register()
$this->app->singleton(CompteurRequetes::class);
```
```php
class TestController extends Controller
{
    public function index(CompteurRequetes $a, CompteurRequetes $b)
    {
        var_dump($a === $b); // true avec singleton() ; false avec bind()
    }
}
```

## Exercice 5

```php
// AppServiceProvider::boot()
use Illuminate\Support\Facades\Gate;

Gate::policy(Annonce::class, GestionAnnoncePolicy::class);
```
```php
$this->authorize('update', $annonce); // fonctionne, résout GestionAnnoncePolicy
```
L'auto-découverte de Laravel cherche par convention `{Modèle}Policy` dans
`app/Policies/` ; dès que le nommage s'en écarte, `Gate::policy()` permet
une liaison manuelle explicite, sans rien changer côté contrôleur ou vue.
