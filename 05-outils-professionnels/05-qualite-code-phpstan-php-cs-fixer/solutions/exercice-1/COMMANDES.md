# Commandes — Exercice 1

```bash
composer require --dev friendsofphp/php-cs-fixer
./vendor/bin/php-cs-fixer fix
```

Corrections automatiquement appliquées sur `avant/src/Exemple.php` (voir
`apres/src/Exemple.php` pour le résultat) :
- Accolade de classe/méthode déplacée sur sa propre ligne.
- `array(1,2,3)` → `[1, 2, 3]` (règle `array_syntax`).
- Indentation uniformisée à 4 espaces.
- Ajout du mot-clé de visibilité `public` manquant sur `total()` (imposé par PSR-12).
- Un espace ajouté autour de `=`.
