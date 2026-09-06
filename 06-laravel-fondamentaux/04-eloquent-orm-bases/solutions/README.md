# Solutions — 06.4 Eloquent ORM : les bases

## Exercice 1

```php
// app/Models/Produit.php
class Produit extends Model
{
    protected $fillable = ['nom', 'prix', 'stock'];
}
```
```php
// Tinker
Produit::create(['nom' => 'Clavier', 'prix' => 49.99, 'stock' => 10]);
Produit::create(['nom' => 'Souris', 'prix' => 19.99, 'stock' => 25]);
Produit::create(['nom' => 'Écran', 'prix' => 199.00, 'stock' => 0]);
```

## Exercice 2

```php
Produit::all();
$produit = Produit::find(1);
$produit->prix = 39.99;
$produit->save();
Produit::find(3)->delete();
```

## Exercice 3

```php
Produit::where('stock', '>', 0)->orderBy('prix', 'desc')->get();
Produit::where('stock', 0)->count();
```

## Exercice 4

```php
// Migration : $table->boolean('disponible')->default(true);
// app/Models/Produit.php
protected $casts = [
    'disponible' => 'boolean',
];
```
```php
$produit = Produit::first();
var_dump($produit->disponible); // bool(true), pas int(1)
```

## Exercice 5

```markdown
| Méthode PDO (module 02.9)                          | Équivalent Eloquent                                          |
|-----------------------------------------------------|----------------------------------------------------------------|
| `INSERT INTO taches (...) VALUES (...)`             | `Tache::create(['titre' => $titre, 'description' => $desc])`  |
| `SELECT * FROM taches WHERE id = :id`               | `Tache::find($id)`                                             |
| `UPDATE taches SET ... WHERE id = :id`              | `Tache::find($id)->update([...])`                              |
| `DELETE FROM taches WHERE id = :id`                 | `Tache::find($id)->delete()`                                   |
| `... WHERE utilisateur_id = :id AND titre LIKE ...` | `Tache::where('utilisateur_id', $id)->where('titre', 'like', "%$terme%")->get()` |

Constat : chaque méthode manuelle de `TacheRepository` (5 à 15 lignes avec
préparation de requête, binding de paramètres, gestion du fetch) devient
une expression Eloquent d'une seule ligne, tout en conservant la même
protection contre l'injection SQL (Eloquent utilise systématiquement des
requêtes préparées en interne, jamais de concaténation de chaînes).
```
