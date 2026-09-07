# Aide-mémoire PHP

## Syntaxe de base

```php
<?php
$variable = "valeur";          // pas de type déclaré, typage dynamique
const CONSTANTE = 'fixe';       // jamais réassignée
echo "Bonjour $variable";        // interpolation (guillemets doubles uniquement)
var_dump($variable);              // type + valeur, pour déboguer
```

## Types et conversions

| Fonction | Rôle |
|---|---|
| `gettype($x)` | Type actuel |
| `(int)`, `(float)`, `(string)`, `(bool)`, `(array)` | Cast explicite |
| `is_int()`, `is_string()`, `is_array()`, `is_null()` | Test de type |
| `settype($x, 'integer')` | Cast qui modifie la variable en place |

## Opérateurs utiles

```php
$a ??  $b     // $a si non null, sinon $b (null coalescing)
$a ??= $b     // assigne $b à $a SEULEMENT si $a est null
$a ?: $b      // $a si "truthy", sinon $b
$a <=> $b     // comparaison spaceship : -1, 0, ou 1
match ($x) {  // équivalent moderne de switch, comparaison stricte, retourne une valeur
    1 => 'un',
    2, 3 => 'deux ou trois',
    default => 'autre',
};
```

## Tableaux

```php
$arr = [1, 2, 3];                       // indexé
$assoc = ['cle' => 'valeur'];             // associatif
array_map(fn($x) => $x * 2, $arr);          // transforme chaque élément
array_filter($arr, fn($x) => $x > 1);         // garde selon condition
array_reduce($arr, fn($c, $x) => $c + $x, 0);   // agrège en une valeur
foreach ($assoc as $cle => $valeur) { ... }       // itération
[$a, $b] = [1, 2];                                  // déstructuration
```

## Fonctions

```php
function nom(string $param, int $defaut = 10): string { ... }  // types stricts recommandés
fn($x) => $x * 2;                                                 // fonction fléchée (arrow function)
function variadique(...$args) { ... }                               // nombre variable d'arguments
```

## POO essentielle

```php
class Produit
{
    public function __construct(
        private readonly string $nom,   // property promotion (PHP 8+)
        private float $prix,
    ) {}

    public function prix(): float { return $this->prix; }
}

interface Payable { public function payer(float $montant): bool; }
abstract class Base { abstract public function methode(): void; }
trait UnTrait { public function partagee() { ... } }

class Enfant extends Parent implements Payable
{
    use UnTrait;
}
```

## Exceptions

```php
try {
    // ...
} catch (TypeException $e) {
    // gérer un type précis
} catch (\Throwable $e) {
    // filet de sécurité générique
} finally {
    // toujours exécuté
}

throw new \InvalidArgumentException("message");
```

## Fichiers et chaînes courantes

```php
file_get_contents($chemin);
file_put_contents($chemin, $contenu);
fopen($chemin, 'r'); fgetcsv($poignee); fclose($poignee);

htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');   // toujours avant d'afficher une donnée utilisateur
trim(), strtolower(), str_contains(), str_starts_with(), sprintf('%05.2f', $x);
```

## PDO (accès base de données sans framework)

```php
$pdo = new PDO("mysql:host=localhost;dbname=app;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = :id");
$stmt->execute(['id' => $id]);
$produit = $stmt->fetch();
```

**Voir aussi :** [Niveau 01](../../01-php-fondamentaux/README.md), [Niveau 02](../../02-php-intermediaire/README.md), [Niveau 03](../../03-php-avance/README.md)
