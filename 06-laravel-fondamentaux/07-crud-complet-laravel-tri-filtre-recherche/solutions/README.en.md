# Solutions — 06.7 Full Laravel CRUD

## Exercise 1

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

## Exercise 2

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
    <button type="submit">Search</button>
</form>
```

## Exercise 3

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
<a href="{{ request()->fullUrlWithQuery(['tri' => 'titre', 'ordre' => request('ordre') === 'asc' ? 'desc' : 'asc']) }}">Title</a>
```

## Exercise 4

```php
$articles = Article::query()
    // ... search when() and orderBy() ...
    ->paginate(10)
    ->withQueryString();
```
```blade
{{ $articles->links() }}
```
Navigating to page 2 with an active search, the URL becomes
`?recherche=xxx&page=2`: `withQueryString()` correctly preserved the
`recherche` parameter alongside the page number.

## Exercise 5

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
The three `when()` calls apply independently: search + sort + status
can all be active simultaneously, each adding its own `WHERE`/`ORDER BY`
clause to the final query — exactly the same composition principle as
`construireFiltres()` from module 02.9, but expressed fluently rather
than by manually building an SQL string.
