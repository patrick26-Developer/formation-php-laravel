# 04.3 — Optimisation des requêtes SQL

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Utiliser `EXPLAIN` pour comprendre comment MySQL exécute une requête.
- Identifier et corriger les requêtes lentes les plus courantes.
- Comprendre l'impact du choix des types de colonnes sur la performance.

## 📋 Prérequis

[04.2 — SQL avancé : jointures, index, transactions](../02-sql-avance-jointures-index-transactions/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### `EXPLAIN` : voir comment MySQL exécute une requête

```sql
EXPLAIN SELECT * FROM commandes WHERE utilisateur_id = 42;
```

Colonnes les plus importantes du résultat :

| Colonne | Signification |
|---|---|
| `type` | Stratégie d'accès : `ALL` (parcours complet, à éviter) est le pire cas, `ref`/`eq_ref`/`const` sont bons (utilisent un index) |
| `key` | L'index réellement utilisé (`NULL` = aucun index utilisé) |
| `rows` | Estimation du nombre de lignes examinées (plus c'est bas, mieux c'est) |
| `Extra` | Informations complémentaires (`Using filesort`, `Using temporary` sont des signaux d'alerte) |

> 📌 `type = ALL` sur une grande table signifie que MySQL lit **toute** la table pour chaque exécution de cette requête — le premier réflexe est alors de vérifier si un index existe sur la colonne du `WHERE` (module 04.2).

### Erreurs qui empêchent l'utilisation d'un index

```sql
-- ❌ Une fonction appliquée à la colonne empêche MySQL d'utiliser l'index sur "email"
SELECT * FROM utilisateurs WHERE LOWER(email) = 'alice@example.com';

-- ✅ Stocker/comparer directement en minuscules, ou utiliser une colonne générée indexée
SELECT * FROM utilisateurs WHERE email = 'alice@example.com';
```

```sql
-- ❌ Un LIKE commençant par % empêche l'utilisation efficace d'un index classique
SELECT * FROM produits WHERE nom LIKE '%phone%';

-- ✅ Un LIKE commençant par le début de la chaîne PEUT utiliser un index
SELECT * FROM produits WHERE nom LIKE 'iphone%';
```

> 📌 Pour une vraie recherche "contient" performante sur de gros volumes, MySQL propose des **index FULLTEXT**, hors du périmètre de cette formation mais bon à savoir : `CREATE FULLTEXT INDEX idx_nom ON produits(nom);` puis `WHERE MATCH(nom) AGAINST('phone')`.

### Choisir les bons types de colonnes

- Utilisez le type **le plus petit possible** qui couvre le besoin réel : `TINYINT` pour un âge, pas `BIGINT`.
- Utilisez `VARCHAR(n)` avec une longueur réaliste plutôt qu'un `TEXT` systématique pour de courtes chaînes (emails, noms) — plus rapide à indexer.
- Utilisez `DECIMAL` pour de l'argent, jamais `FLOAT`/`DOUBLE` (imprécision d'arrondi sur les calculs financiers).
- Utilisez `ENUM` ou une table de référence pour un ensemble fixe de valeurs plutôt qu'un `VARCHAR` libre.

### `SELECT *` vs colonnes explicites

```sql
-- ❌ Récupère TOUTES les colonnes, même celles non utilisées (coût réseau/mémoire inutile)
SELECT * FROM utilisateurs WHERE id = 1;

-- ✅ Ne récupère que ce dont on a réellement besoin
SELECT nom, email FROM utilisateurs WHERE id = 1;
```

> 📌 Sur une petite table, la différence est négligeable. Sur une table avec des colonnes volumineuses (`TEXT`, `JSON`) ou beaucoup de colonnes, la différence devient significative à grande échelle.

### Le problème N+1, revu avec `EXPLAIN`

Déjà vu au [module 03.6](../../03-php-avance/06-performance-et-optimisation/README.md) : une requête dans une boucle PHP est souvent le problème de performance le plus coûteux d'une application, bien avant les micro-optimisations de types de colonnes. **Toujours vérifier en premier si une boucle exécute des requêtes répétées** avant d'optimiser une requête individuelle.

## ✅ Points clés à retenir

- `EXPLAIN` avant d'optimiser : ne jamais deviner, toujours vérifier `type`, `key`, `rows`.
- Une fonction appliquée à une colonne indexée dans un `WHERE` empêche souvent l'utilisation de l'index.
- Choisir le type de colonne le plus adapté (taille, précision) a un vrai impact à grande échelle.
- Le problème N+1 (module 03.6) reste, en pratique, la cause la plus fréquente de lenteur applicative.

## ➡️ Pour aller plus loin

- [dev.mysql.com — EXPLAIN Output Format](https://dev.mysql.com/doc/refman/8.0/en/explain-output.html)
- [Module 08.2 — Cache et optimisation de performance (Laravel)](../../08-laravel-avance/02-cache-optimisation-performance/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [04.2 — SQL avancé](../02-sql-avance-jointures-index-transactions/README.md) · **Suite :** [04.4 — Exercices pratiques SQL](../04-exercices-pratiques-sql/README.md)
