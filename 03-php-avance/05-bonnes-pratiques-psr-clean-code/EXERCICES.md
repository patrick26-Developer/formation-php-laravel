# Exercices — 03.5 Bonnes pratiques, PSR-12, Clean Code

## Exercice 1 — Reformater du code (facile)

Ce code ne respecte pas PSR-12. Réécrivez-le en corrigeant le style (accolades, indentation, espacement) :

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

## Exercice 2 — Renommer pour clarifier (facile)

Renommez les identifiants de ce code pour qu'ils expriment clairement leur intention, sans changer le comportement :

```php
<?php
function calc($a, $b, $t) {
    if ($t === 1) {
        return $a + $b;
    }
    return $a - $b;
}
```

## Exercice 3 — Extraire une fonction trop longue (moyen)

Cette fonction fait plusieurs choses à la fois. Découpez-la en plusieurs fonctions bien nommées, chacune avec une seule responsabilité :

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

## Exercice 4 — Remplacer un nombre magique (moyen)

Repérez et corrigez le(s) nombre(s)/chaîne(s) magique(s) dans ce code, en utilisant un enum ou des constantes nommées :

```php
<?php
function peutPublier(int $role): bool {
    return $role === 1 || $role === 2;
}
```

## Exercice 5 — Appliquer le principe de responsabilité unique (difficile)

Cette classe viole clairement le principe de responsabilité unique. Séparez-la en plusieurs classes cohérentes, chacune avec une seule raison de changer :

```php
<?php
class GestionUtilisateur {
    public function creerCompte(string $email, string $motDePasse): void {
        // validation des données
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email invalide");
        }
        // hachage et sauvegarde en base
        $hash = password_hash($motDePasse, PASSWORD_DEFAULT);
        // ... requête SQL d'insertion ...

        // envoi d'email de bienvenue
        mail($email, "Bienvenue", "Merci de votre inscription");

        // journalisation
        file_put_contents('journal.log', date('Y-m-d H:i:s') . " - Nouveau compte : $email\n", FILE_APPEND);
    }
}
```

---

Comparez avec [solutions/](solutions/) une fois terminé.
