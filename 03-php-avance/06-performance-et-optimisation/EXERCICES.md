# Exercices — 03.6 Performance et optimisation PHP

## Exercice 1 — Mesurer un script (facile)

Écrivez un script qui mesure et affiche le temps d'exécution d'une boucle calculant la somme des carrés de 1 à 5 000 000.

## Exercice 2 — Comparer deux approches (facile)

Comparez le temps d'exécution de la concaténation de chaînes en boucle (`.=`) contre l'accumulation dans un tableau + `implode()`, sur 100 000 éléments. Affichez les deux durées mesurées.

## Exercice 3 — Repérer un problème N+1 (moyen)

Ce code simule un problème N+1 avec des tableaux PHP (pas de vraie base de données nécessaire) :

```php
<?php
$commandes = [
    ['id' => 1, 'client_id' => 1],
    ['id' => 2, 'client_id' => 2],
    ['id' => 3, 'client_id' => 1],
];
$clients = [1 => ['nom' => 'Alice'], 2 => ['nom' => 'Bob']];

function trouverClient(int $id, array $clients): array {
    // simule une "requête" coûteuse à chaque appel
    usleep(1000);
    return $clients[$id];
}

foreach ($commandes as $commande) {
    $client = trouverClient($commande['client_id'], $clients);
    echo "Commande {$commande['id']} pour {$client['nom']}\n";
}
```

Réécrivez-le pour éliminer l'appel répété à `trouverClient()` dans la boucle (indice : la fonction est déjà appelée avec un tableau `$clients` complet — utilisez-le directement).

## Exercice 4 — Pagination vs chargement complet (moyen)

Avec un tableau de 10 000 éléments générés (`range(1, 10000)`), comparez le temps de `array_slice($tableau, 9990, 10)` contre une boucle `foreach` qui parcourt tout le tableau pour ne garder que les 10 derniers éléments. Concluez en commentaire sur l'approche à privilégier.

## Exercice 5 — Profiler une fonction récursive naïve (difficile)

La suite de Fibonacci calculée de façon récursive naïve est un classique de mauvaise performance :

```php
<?php
function fibonacci(int $n): int {
    if ($n <= 1) return $n;
    return fibonacci($n - 1) + fibonacci($n - 2);
}
```

Mesurez le temps pour `fibonacci(30)`. Puis réécrivez une version avec **mémoïsation** (mise en cache des résultats déjà calculés dans un tableau) et comparez les deux durées.

---

Comparez avec [solutions/](solutions/) une fois terminé.
