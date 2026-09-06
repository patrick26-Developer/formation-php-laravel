# Solutions — 06.7 CRUD complet Laravel

## Exercice 1

```php
class ArticleController extends Controller
{
    public function index() { return view('articles.index', ['articles' => Article::all()]); }
    public function create() { return view('articles.create'); }
    public function store(Request $request) {
        $data = $request->validate(['titre' => 'required|max:150', 'contenu' => 'required']);
        Article::create($data);
        return redirect()->route('articles.index');
    }
    public function show(Article $article) { return view('articles.show', compact('article')); }
    public function edit(Article $article) { return view('articles.edit', compact('article')); }
    public function update(Request $request, Article $article) {
        $data = $request->validate(['titre' => 'required|max:150', 'contenu' => 'required']);
        $article->update($data);
        return redirect()->route('articles.index');
    }
    public function destroy(Article $article) {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
```

## Exercice 2

```php
public function index(Request $request)
{
    $articles = Article::query()
        ->when($request->filled('recherche'), fn ($q) => $q->where('titre', 'like', '%' . $request->recherche . '%'))
        ->get();

    return view('articles.index', compact('articles'));
}
```
```blade
<form method="GET">
    <input type="text" name="recherche" value="{{ request('recherche') }}">
    <button type="submit">Rechercher</button>
</form>
```

## Exercice 3

```php
$colonnesAutorisees = ['titre', 'created_at'];
$tri = in_array($request->input('tri'), $colonnesAutorisees, true) ? $request->input('tri') : 'created_at';
$ordre = $request->input('ordre') === 'asc' ? 'asc' : 'desc';

$articles = Article::query()
    ->when($request->filled('recherche'), fn ($q) => $q->where('titre', 'like', '%' . $request->recherche . '%'))
    ->orderBy($tri, $ordre)
    ->get();
```
```blade
<a href="{{ request()->fullUrlWithQuery(['tri' => 'titre', 'ordre' => request('ordre') === 'asc' ? 'desc' : 'asc']) }}">Titre</a>
```

## Exercice 4

```php
$articles = Article::query()
    // ... when() de recherche et orderBy() ...
    ->paginate(10)
    ->withQueryString();
```
```blade
{{ $articles->links() }}
```
En naviguant vers la page 2 avec une recherche active, l'URL devient
`?recherche=xxx&page=2` : `withQueryString()` a bien préservé le paramètre
`recherche` en plus du numéro de page.

## Exercice 5

```php
public function index(Request $request)
{
    $colonnesAutorisees = ['titre', 'created_at'];
    $tri = in_array($request->input('tri'), $colonnesAutorisees, true) ? $request->input('tri') : 'created_at';
    $ordre = $request->input('ordre') === 'asc' ? 'asc' : 'desc';
    $statut = $request->input('statut', 'tous');

    $articles = Article::query()
        ->when($request->filled('recherche'), fn ($q) => $q->where('titre', 'like', '%' . $request->recherche . '%'))
        ->when($statut === 'publies', fn ($q) => $q->where('publie', true))
        ->when($statut === 'brouillons', fn ($q) => $q->where('publie', false))
        ->orderBy($tri, $ordre)
        ->paginate(10)
        ->withQueryString();

    return view('articles.index', compact('articles'));
}
```
Les trois `when()` s'appliquent indépendamment : recherche + tri + statut
peuvent tous être actifs simultanément, chacun ajoutant sa propre clause
`WHERE`/`ORDER BY` à la requête finale — exactement le même principe de
composition que `construireFiltres()` du module 02.9, mais exprimé de façon
fluide plutôt qu'en construisant une chaîne SQL manuellement.
