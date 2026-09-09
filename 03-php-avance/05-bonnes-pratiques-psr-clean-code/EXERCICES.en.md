# Exercises — 03.5 Best Practices, PSR-12, Clean Code

## Exercise 1 — Reformat code (easy)

This code doesn't follow PSR-12. Rewrite it, fixing the style (braces, indentation, spacing):

```php
<?php
class produit{
  private $nom;
  function __construct($nom){
  $this->nom=$nom;}
  function getNom(){
      return $this->nom;
  }
}
```

## Exercise 2 — Rename for clarity (easy)

Rename this code's identifiers so they clearly express their intent, without changing the behavior:

```php
<?php
function calc($a, $b, $t) {
    if ($t === 1) {
        return $a + $b;
    }
    return $a - $b;
}
```

## Exercise 3 — Extract an overly long function (medium)

This function does several things at once. Break it into several well-named functions, each with a single responsibility:

```php
<?php
function traiterCommande(array $commande): string {
    $total = 0;
    foreach ($commande['articles'] as $article) {
        $total += $article['prix'] * $article['quantite'];
    }
    if ($total > 100) {
        $total = $total * 0.9;
    }
    $tva = $total * 0.2;
    $totalTTC = $total + $tva;
    $facture = "Total HT: $total, TVA: $tva, Total TTC: $totalTTC";
    return $facture;
}
```

## Exercise 4 — Replace a magic number (medium)

Spot and fix the magic number(s)/string(s) in this code, using an enum or named constants:

```php
<?php
function peutPublier(int $role): bool {
    return $role === 1 || $role === 2;
}
```

## Exercise 5 — Apply the single responsibility principle (hard)

This class clearly violates the single responsibility principle. Split it into several coherent classes, each with a single reason to change:

```php
<?php
class GestionUtilisateur {
    public function creerCompte(string $email, string $motDePasse): void {
        // validate the data
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email");
        }
        // hash and save to the database
        $hash = password_hash($motDePasse, PASSWORD_DEFAULT);
        // ... insert SQL query ...

        // send welcome email
        mail($email, "Welcome", "Thank you for signing up");

        // logging
        file_put_contents('journal.log', date('Y-m-d H:i:s') . " - New account: $email\n", FILE_APPEND);
    }
}
```

---

Compare with [solutions/](solutions/README.en.md) once done.
