# Exercices — 03.1 Design patterns en PHP

## Exercice 1 — Factory de formes (facile)

Reprenez les classes `Rectangle`, `Cercle`, `Triangle` du [module 02.2](../../02-php-intermediaire/02-poo-heritage-interfaces-abstraction/README.md). Créez une `FormeFactory::creer(string $type, array $parametres): FormeGeometrique` qui instancie la bonne classe selon `$type` (`'rectangle'`, `'cercle'`, `'triangle'`).

## Exercice 2 — Strategy de tri (facile)

Créez une interface `StrategieTri` avec une méthode `trier(array $donnees): array`. Implémentez `TriAlphabetique` et `TriParLongueur` (trie des chaînes par longueur croissante). Une classe `ListeMots` prend une stratégie en constructeur et l'utilise dans une méthode `obtenirTriee(array $mots): array`.

## Exercice 3 — Observer pour un système de notation (moyen)

Créez un `GestionnaireAvis` (le sujet) avec une méthode `ajouterAvis(int $note): void` qui notifie ses observateurs. Créez un observateur `CalculMoyenneObservateur` qui maintient une moyenne à jour à chaque nouvel avis, et un `AlerteAvisNegatifObservateur` qui affiche une alerte si la note est inférieure à 2 (sur 5).

## Exercice 4 — Factory + Strategy combinés (moyen)

Combinez les deux premiers exercices : une `NotificationFactory::creer(string $canal): StrategieNotification` (canal = 'email' ou 'sms', chaque stratégie implémentant `envoyer(string $message): string`). Utilisez la factory pour créer et utiliser une stratégie selon une variable.

## Exercice 5 — Repository avec Strategy de tri injectée (difficile)

Reprenez `LivreRepository` du [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md). Plutôt qu'un paramètre `string $tri`, injectez une interface `CritereTri` avec une méthode `versSql(): string` (retournant par exemple `"annee DESC"`), validée en amont. Implémentez `TriParAnnee` et `TriParTitre`. Expliquez en commentaire l'avantage (ou l'inconvénient) de cette approche par rapport à la simple liste blanche du module 02.9.

---

Comparez avec [solutions/](solutions/) une fois terminé.
