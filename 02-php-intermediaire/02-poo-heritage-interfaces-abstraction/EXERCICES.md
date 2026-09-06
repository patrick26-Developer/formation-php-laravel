# Exercices — 02.2 Héritage, interfaces, abstraction

## Exercice 1 — Hiérarchie de véhicules (facile)

Créez une classe `Vehicule` (propriété `marque`, méthode `demarrer(): string`). Créez `Voiture` et `Moto` qui en héritent, chacune ajoutant une méthode spécifique (`ouvrirCoffre()` pour Voiture, `fairePetPet()` pour Moto). Instanciez les deux et appelez toutes leurs méthodes.

## Exercice 2 — `parent::` (facile)

Reprenez `Vehicule` avec une méthode `demarrer(): string` qui retourne `"$marque démarre."`. Dans `Voiture`, redéfinissez `demarrer()` pour qu'elle appelle la version parente puis ajoute `" Vérification de la ceinture."`.

## Exercice 3 — Interface `Notifiable` (moyen)

Créez une interface `Notifiable` avec une méthode `envoyerNotification(string $message): string`. Implémentez-la dans deux classes `Email` et `SMS`, chacune formatant le message différemment (`"Email envoyé : ..."` / `"SMS envoyé : ..."`). Écrivez une fonction `notifierTous(array $canaux, string $message): void` qui accepte un tableau d'objets `Notifiable` et appelle leur méthode.

## Exercice 4 — Classe abstraite `Employe` (moyen)

Créez une classe abstraite `Employe` avec une propriété `nom`, une méthode abstraite `calculerSalaire(): float`, et une méthode concrète `presenter(): string` qui utilise `calculerSalaire()`. Créez `EmployeFixe` (salaire mensuel fixe) et `EmployeCommission` (salaire de base + pourcentage sur un montant de ventes).

## Exercice 5 — Système de formes avec polymorphisme (difficile)

Reprenez l'exemple `FormeGeometrique` du cours, ajoutez une classe `Triangle` (base, hauteur), puis écrivez une fonction `calculerAireTotale(array $formes): float` qui accepte un tableau mêlant `Rectangle`, `Cercle` et `Triangle`, et retourne la somme de toutes leurs aires — sans jamais vérifier le type concret de chaque élément.

---

Comparez avec [solutions/](solutions/) une fois terminé.
