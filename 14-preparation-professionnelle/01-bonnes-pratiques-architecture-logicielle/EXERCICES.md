# Exercices — 14.1 Bonnes pratiques d'architecture logicielle

## Exercice 1 — Identifier le principe (facile)

Pour chacun de ces extraits de la formation, nommez le principe SOLID/architectural illustré : (a) `AnnoncePolicy` centralisant les règles d'autorisation, (b) `RapportGenerator::lireCsv()`/`construireHtml()`/`convertirEnPdf()` séparées, (c) `Cache::remember()` évitant de recalculer une donnée coûteuse.

## Exercice 2 — Diagnostiquer un signal (facile)

Un contrôleur `InvoiceController::genererPdf()` fait 180 lignes : requêtes SQL directes, formatage de dates, appel à Dompdf, envoi d'email. Identifiez au moins 3 responsabilités mélangées et proposez une décomposition (quelles classes/services créeriez-vous ?).

## Exercice 3 — Éviter le sur-engineering (moyen)

Un développeur junior propose d'introduire un Repository, une interface `ProduitRepositoryInterface`, et un pattern Factory pour un simple CRUD de 3 champs (nom, prix, stock) sans logique métier particulière. Rédigez, en 5-6 phrases, l'argumentation que vous lui donneriez pour l'inviter à simplifier — sans le décourager.

## Exercice 4 — Argumenter un choix architectural (moyen)

Reprenez la décision transactionnelle du `BillingService` (grand projet 13.4) : un échec de paiement laisse la facture "impayee" plutôt que de tout annuler. Rédigez un court paragraphe (comme si vous le présentiez en entretien) expliquant CE choix, POURQUOI il diffère du tunnel d'achat e-commerce, et QUEL risque il éviterait de ne pas le faire.

## Exercice 5 — Concevoir une évolution justifiée (difficile)

Le [mini-projet Plateforme d'annonces](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) grandit : 200 000 annonces, 50 catégories, une équipe de 6 développeurs. Identifiez, parmi les signaux du cours, lesquels justifieraient une évolution d'architecture pour CE projet précis, et lesquels ne la justifieraient PAS encore. Proposez un plan d'évolution en 3 étapes, priorisé par impact/risque.

---

*(Ce module étant réflexif, il n'y a pas de "solutions" figées à comparer — mais un corrigé indicatif est fourni pour orienter votre réflexion.)*

Voir [solutions/README.md](solutions/README.md).
