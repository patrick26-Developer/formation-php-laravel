# Solutions — 08.4 Service Providers and Custom Packages

## Exercise 1

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

## Exercise 2

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

## Exercise 3

```php
class HorodateurFige implements Horodateur
{
    public function maintenant(): string { return '2024-01-01 00:00:00'; }
}
```
```php
// Only this line changes:
$this->app->bind(Horodateur::class, HorodateurFige::class);
```
The controller declaring `public function __construct(Horodateur $horodateur)`
is never modified: it only knows the interface.

## Exercise 4

```php
// AppServiceProvider::register()
$this->app->singleton(CompteurRequetes::class);
```
```php
class TestController extends Controller
{
    public function index(CompteurRequetes $a, CompteurRequetes $b)
    {
        var_dump($a === $b); // true with singleton(); false with bind()
    }
}
```

## Exercise 5

```php
// AppServiceProvider::boot()
use Illuminate\Support\Facades\Gate;

Gate::policy(Annonce::class, GestionAnnoncePolicy::class);
```
```php
$this->authorize('update', $annonce); // works, resolves GestionAnnoncePolicy
```
Laravel's auto-discovery looks by convention for `{Model}Policy` in
`app/Policies/`; as soon as the naming deviates from that,
`Gate::policy()` allows an explicit manual binding, with no change
needed on the controller or view side.
