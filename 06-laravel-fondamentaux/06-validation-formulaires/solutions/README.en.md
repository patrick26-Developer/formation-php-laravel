# Solutions — 06.6 Form Validation

## Exercise 1

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

## Exercise 2

```php
$request->validate(
    [
        'nom' => 'required|string|max:150',
        'prix' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ],
    [
        'nom.required' => 'The product name is required.',
        'nom.max' => 'The name cannot exceed :max characters.',
        'prix.required' => 'The price is required.',
        'prix.numeric' => 'The price must be a number.',
        'prix.min' => 'The price cannot be negative.',
        'stock.integer' => 'The stock must be a whole number.',
    ]
);
```

## Exercise 3

```php
// Registration
$request->validate([
    'email' => 'required|email|unique:users,email',
]);

// Product
$request->validate([
    'categorie_id' => 'required|exists:categories,id',
]);
```

## Exercise 4

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

## Exercise 5

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

Explanation: on **creation**, no record exists yet with this ID, so
`unique` should apply with no exception. On **update**, the record
currently being edited already has this `code` in the database —
without `->ignore($this->produit)`, validation would systematically
fail by comparing the record to... itself, preventing any update that
doesn't change this field.
