# 04.1 — Modélisation relationnelle (MCD/MLD)

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre pourquoi on modélise avant de coder.
- Identifier entités, attributs et relations dans un besoin métier.
- Comprendre les cardinalités (1-1, 1-N, N-N).
- Passer d'un Modèle Conceptuel de Données (MCD) à un Modèle Logique de Données (MLD).

## 📋 Prérequis

[Niveau 02 — PHP Intermédiaire](../../02-php-intermediaire/README.md) complété.

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Pourquoi modéliser avant de coder ?

Créer directement des tables SQL "à l'instinct" mène presque toujours à des données dupliquées, incohérentes, ou à une structure qu'il faut ensuite migrer douloureusement. La **modélisation relationnelle** est une étape de réflexion, sur papier ou dans un outil dédié, **avant** d'écrire `CREATE TABLE`.

### Le vocabulaire de base

| Terme | Définition | Exemple |
|---|---|---|
| **Entité** | Un objet ou concept métier qu'on veut représenter | `Utilisateur`, `Commande`, `Produit` |
| **Attribut** | Une propriété d'une entité | `Utilisateur` a un `nom`, un `email` |
| **Relation** (ou association) | Un lien entre deux entités | Un `Utilisateur` **passe** des `Commande` |
| **Cardinalité** | Combien d'instances participent à une relation | Un utilisateur peut passer 0 à N commandes |

### Les trois types de cardinalités

**1-1 (un à un)** : chaque instance d'une entité correspond à au plus une instance de l'autre.
```
Utilisateur (1) ──── (1) ProfilDetaille
```
Exemple : chaque utilisateur a exactement un profil détaillé, et vice-versa.

**1-N (un à plusieurs)** : une instance d'un côté peut correspondre à plusieurs de l'autre, mais pas l'inverse.
```
Utilisateur (1) ──── (N) Commande
```
Exemple : un utilisateur peut passer plusieurs commandes, mais chaque commande appartient à un seul utilisateur. C'est la relation la plus courante — vous l'avez déjà implémentée au [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md) via `utilisateur_id` sur la table `taches`.

**N-N (plusieurs à plusieurs)** : des instances des deux côtés peuvent se correspondre librement.
```
Etudiant (N) ──── (N) Cours
```
Exemple : un étudiant peut suivre plusieurs cours, et un cours peut avoir plusieurs étudiants. **Une relation N-N nécessite obligatoirement une table intermédiaire** (dite table de jointure ou table pivot) lors du passage au MLD.

### Du MCD au MLD : traduire les relations en tables

**Relation 1-N** : la clé primaire du côté "1" devient une **clé étrangère** dans la table du côté "N".

```sql
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);
```

**Relation N-N** : une table intermédiaire contient les clés étrangères des deux tables liées.

```sql
CREATE TABLE etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intitule VARCHAR(150) NOT NULL
);

-- Table pivot : chaque ligne représente "cet étudiant suit ce cours"
CREATE TABLE inscriptions (
    etudiant_id INT NOT NULL,
    cours_id INT NOT NULL,
    PRIMARY KEY (etudiant_id, cours_id), -- clé primaire composite : empêche les doublons
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id),
    FOREIGN KEY (cours_id) REFERENCES cours(id)
);
```

> 📌 Cette table pivot (`inscriptions`) est exactement ce que Laravel appelle une "pivot table" pour les relations `belongsToMany`, vues au [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md). Comprendre ce mécanisme en SQL pur rend cette relation Eloquent immédiatement intuitive.

**Relation 1-1** : la clé étrangère peut être placée d'un côté ou de l'autre, généralement avec une contrainte `UNIQUE` pour garantir qu'elle ne se répète pas.

```sql
CREATE TABLE profils_detailles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL UNIQUE, -- UNIQUE garantit la relation 1-1
    biographie TEXT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);
```

### Les formes normales (aperçu pratique)

La **normalisation** évite la duplication et les incohérences de données. Sans entrer dans la théorie complète (1FN, 2FN, 3FN), la règle pratique la plus utile :

> Chaque information ne doit être stockée **qu'à un seul endroit**. Si vous stockez le nom d'un client à la fois dans `clients` et recopié dans chaque `commandes`, une mise à jour du nom devra être répétée partout — source d'incohérences. Stockez plutôt `client_id` dans `commandes`, et allez chercher le nom via une jointure (module 04.2) quand nécessaire.

## ✅ Points clés à retenir

- Modéliser avant de coder évite des migrations douloureuses plus tard.
- Trois cardinalités : 1-1 (rare), 1-N (la plus courante), N-N (nécessite une table pivot).
- La clé étrangère se place toujours du côté "N" d'une relation 1-N.
- Ne jamais dupliquer une information qui peut être retrouvée via une relation.

## ➡️ Pour aller plus loin

- [Module 04.2 — SQL avancé : jointures, index, transactions](../02-sql-avance-jointures-index-transactions/README.md)
- [Module 06.5 — Migrations, seeders, factories (Laravel)](../../06-laravel-fondamentaux/05-migrations-seeders-factories/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 03 — PHP Avancé](../../03-php-avance/README.md) · **Suite :** [04.2 — SQL avancé](../02-sql-avance-jointures-index-transactions/README.md)
