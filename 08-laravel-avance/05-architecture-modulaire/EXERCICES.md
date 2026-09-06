# Exercices — 08.5 Architecture modulaire et multi-tenancy

## Exercice 1 — Identifier un besoin de réorganisation (facile)

Listez, pour le [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md), tous les fichiers liés au domaine "Annonce" (modèle, contrôleur, policy, requests, notification). Ce projet a-t-il réellement besoin d'une réorganisation par domaine ? Justifiez.

## Exercice 2 — Colonne tenant_id (facile)

Ajoutez une colonne `tenant_id` à une table `projets` simulée. Créez deux tenants et des projets pour chacun.

## Exercice 3 — Scope global de tenant (moyen)

Implémentez le scope global du cours sur le modèle `Projet`. Vérifiez que `Projet::all()` ne retourne que les projets du tenant de l'utilisateur connecté (simulez la connexion via Tinker en assignant `Auth::login()`).

## Exercice 4 — Démontrer la faille du contournement (moyen)

Montrez qu'une requête `DB::table('projets')->get()` (Query Builder brut, sans Eloquent) contourne bien le scope global — affichant les projets de TOUS les tenants. Expliquez en commentaire pourquoi cette découverte justifie une règle d'équipe stricte ("toujours passer par le modèle Eloquent, jamais par DB:: directement pour les tables tenant-isolées").

## Exercice 5 — Comparer les trois stratégies (difficile)

Rédigez un court comparatif (`STRATEGIE.md`) argumentant, pour un cas fictif (une plateforme SaaS de gestion de cabinets médicaux, données sensibles), quelle stratégie de multi-tenancy choisir parmi les trois du cours, en pesant le compromis sécurité/complexité/coût d'infrastructure.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
