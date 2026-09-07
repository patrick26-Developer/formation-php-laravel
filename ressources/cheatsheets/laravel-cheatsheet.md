# Aide-mémoire Laravel

## Artisan essentiel

```bash
php artisan serve
php artisan make:model Produit -mfc          # modèle + migration + factory + contrôleur
php artisan make:controller ProduitController --resource
php artisan make:request StoreProduitRequest
php artisan make:policy ProduitPolicy --model=Produit
php artisan make:middleware VerifierRole
php artisan make:notification CommandeNotification
php artisan make:job TraiterCommande
php artisan make:livewire ComposantExemple

php artisan migrate
php artisan migrate:fresh --seed             # JAMAIS en production
php artisan migrate:rollback
php artisan db:seed

php artisan route:list
php artisan tinker
php artisan config:clear
php artisan optimize / optimize:clear         # à faire avant/après chaque déploiement
```

## Routing

```php
Route::get('/x', [Controleur::class, 'methode'])->name('x.index');
Route::resource('produits', ProduitController::class);        // web : 7 routes
Route::apiResource('produits', ProduitController::class);      // API : 5 routes (sans create/edit)
Route::middleware(['auth', 'can:acceder-admin'])->group(fn () => ...);
```

## Eloquent — CRUD et requêtes

```php
Produit::create([...]);
Produit::find($id); / findOrFail($id);
Produit::where('actif', true)->orderBy('nom')->paginate(10);
$produit->update([...]); $produit->delete();

Produit::with('categorie')->get();              // eager loading, contre le N+1
Produit::withCount('avis')->get();
$produit->load('categorie');                       // eager loading a posteriori

$model->belongsTo(Autre::class);
$model->hasMany(Autre::class);
$model->belongsToMany(Autre::class)->withPivot('x')->withTimestamps();
```

## Validation

```php
$request->validate([
    'titre' => 'required|string|max:150',
    'email' => 'required|email|unique:users,email',
    'prix' => 'required|numeric|min:0',
    'image' => 'nullable|image|mimes:jpg,png|max:2048',
]);
```

## Blade

```blade
{{ $variable }}            {{-- échappé --}}
{!! $html !!}               {{-- NON échappé, prudence --}}
@if / @foreach / @forelse ... @empty
@extends('layouts.app') @section('x') ... @endsection
<x-mon-composant :prop="$valeur">slot</x-mon-composant>
@csrf @method('PUT')
@auth ... @endauth   @can('update', $model) ... @endcan
```

## Authentification et autorisation

```php
Auth::check(); Auth::user(); Auth::id();
$request->user()->can('update', $model);
$this->authorize('update', $model);      // dans un contrôleur, lève 403 si refusé
Gate::define('nom', fn ($user) => ...);
```

## Cache et Queue

```php
Cache::remember('cle', now()->addHour(), fn () => calculCouteux());
Cache::forget('cle');

MonJob::dispatch($donnees);              // implements ShouldQueue
MonEvent::dispatch($donnees);            // Listeners réagissent séparément
```

## Tests (Pest)

```php
test('description', function () {
    $response = $this->actingAs($user)->get('/route');
    $response->assertOk(); // ou ->assertStatus(200), ->assertRedirect(), ->assertForbidden()
    $this->assertDatabaseHas('table', ['champ' => 'valeur']);
});

Queue::fake(); Notification::fake(); Mail::fake();
Livewire::test(Composant::class)->set('prop', 'x')->call('methode')->assertSee('...');
```

## API (Sanctum)

```php
$token = $user->createToken('nom')->plainTextToken;
Route::middleware('auth:sanctum')->group(fn () => ...);
return MonResource::collection($paginator);   // avec whenLoaded()/whenCounted()
```

**Voir aussi :** [Niveau 06](../../06-laravel-fondamentaux/README.md) à [Niveau 11](../../11-devops-docker-cicd-avance/README.md)
