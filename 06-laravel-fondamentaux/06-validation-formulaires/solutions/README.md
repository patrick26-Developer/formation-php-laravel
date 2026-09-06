# Solutions — 06.6 Validation des formulaires

## Exercice 1

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:150',
        'prix' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    Produit::create($validated);

    return redirect()->route('produits.index');
}
```

## Exercice 2

```php
$request->validate(
    [
        'nom' => 'required|string|max:150',
        'prix' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ],
    [
        'nom.required' => 'Le nom du produit est obligatoire.',
        'nom.max' => 'Le nom ne peut pas dépasser :max caractères.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.numeric' => 'Le prix doit être un nombre.',
        'prix.min' => 'Le prix ne peut pas être négatif.',
        'stock.integer' => 'Le stock doit être un nombre entier.',
    ]
);
```

## Exercice 3

```php
// Inscription
$request->validate([
    'email' => 'required|email|unique:users,email',
]);

// Produit
$request->validate([
    'categorie_id' => 'required|exists:categories,id',
]);
```

## Exercice 4

```bash
php artisan make:request StoreProduitRequest
```
```php
class StoreProduitRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:150',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }
}
```
```php
public function store(StoreProduitRequest $request)
{
    Produit::create($request->validated());
    return redirect()->route('produits.index');
}
```

## Exercice 5

```php
use Illuminate\Validation\Rule;

class StoreProduitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:produits,code',
        ];
    }
}

class UpdateProduitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', Rule::unique('produits')->ignore($this->produit)],
        ];
    }
}
```

Explication : à la **création**, aucun enregistrement n'existe encore avec
cet ID, donc `unique` doit s'appliquer sans exception. À la **modification**,
l'enregistrement en cours d'édition possède déjà ce `code` en base — sans
`->ignore($this->produit)`, la validation échouerait systématiquement en
comparant l'enregistrement à... lui-même, empêchant toute modification qui
ne change pas ce champ.
