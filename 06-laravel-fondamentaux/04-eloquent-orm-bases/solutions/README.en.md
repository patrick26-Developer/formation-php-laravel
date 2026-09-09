# Solutions — 06.4 Eloquent ORM: The Basics

## Exercise 1

```php
// app/Models/Produit.php
class Produit extends Model
{
    protected $fillable = ['nom', 'prix', 'stock'];
}
```
```php
// Tinker
Produit::create(['nom' => 'Keyboard', 'prix' => 49.99, 'stock' => 10]);
Produit::create(['nom' => 'Mouse', 'prix' => 19.99, 'stock' => 25]);
Produit::create(['nom' => 'Monitor', 'prix' => 199.00, 'stock' => 0]);
```

## Exercise 2

```php
Produit::all();
$produit = Produit::find(1);
$produit->prix = 39.99;
$produit->save();
Produit::find(3)->delete();
```

## Exercise 3

```php
Produit::where('stock', '>', 0)->orderBy('prix', 'desc')->get();
Produit::where('stock', 0)->count();
```

## Exercise 4

```php
// Migration: $table->boolean('disponible')->default(true);
// app/Models/Produit.php
protected $casts = [
    'disponible' => 'boolean',
];
```
```php
$produit = Produit::first();
var_dump($produit->disponible); // bool(true), not int(1)
```

## Exercise 5

```markdown
| PDO method (module 02.9)                           | Eloquent equivalent                                          |
|-----------------------------------------------------|----------------------------------------------------------------|
| `INSERT INTO taches (...) VALUES (...)`             | `Tache::create(['titre' => $titre, 'description' => $desc])`  |
| `SELECT * FROM taches WHERE id = :id`               | `Tache::find($id)`                                             |
| `UPDATE taches SET ... WHERE id = :id`              | `Tache::find($id)->update([...])`                              |
| `DELETE FROM taches WHERE id = :id`                 | `Tache::find($id)->delete()`                                   |
| `... WHERE utilisateur_id = :id AND titre LIKE ...` | `Tache::where('utilisateur_id', $id)->where('titre', 'like', "%$terme%")->get()` |

Observation: each manual `TacheRepository` method (5 to 15 lines with
query preparation, parameter binding, fetch handling) becomes a
single-line Eloquent expression, while keeping the same protection
against SQL injection (Eloquent systematically uses prepared statements
internally, never string concatenation).
```
