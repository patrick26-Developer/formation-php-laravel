# Exercices — 09.5 Versioning et documentation OpenAPI

## Exercice 1 — Installer L5-Swagger (facile)

Installez `darkaonline/l5-swagger` sur votre projet. Générez la documentation et accédez à `/api/documentation`.

## Exercice 2 — Documenter un endpoint GET (facile)

Ajoutez des annotations `@OA\Get` complètes pour `GET /api/v1/annonces/{id}`, incluant le paramètre de chemin et une réponse 200.

## Exercice 3 — Documenter les erreurs (moyen)

Complétez la documentation de l'exercice 2 avec les réponses 404 (annonce non trouvée) et 401 (non authentifié si la route est protégée).

## Exercice 4 — Documenter un POST avec corps de requête (moyen)

Documentez `POST /api/v1/annonces` avec `@OA\RequestBody` décrivant les champs attendus (`titre`, `prix`, etc.) et leurs contraintes de validation.

## Exercice 5 — Introduire une v2 sans casser la v1 (difficile)

Simulez une évolution : la v2 de l'API renomme le champ `prix` en `prix_ttc` et ajoute `prix_ht`. Implémentez `V1\AnnonceResource` (garde `prix`) et `V2\AnnonceResource` (nouveaux champs), routées séparément (`/api/v1/annonces`, `/api/v2/annonces`), partageant le même contrôleur/modèle sous-jacent. Documentez les deux versions dans Swagger.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
