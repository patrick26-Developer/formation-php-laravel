# Exercises — 09.5 Versioning and OpenAPI Documentation

## Exercise 1 — Installing L5-Swagger (easy)

Install `darkaonline/l5-swagger` on your project. Generate the documentation and access `/api/documentation`.

## Exercise 2 — Documenting a GET endpoint (easy)

Add complete `@OA\Get` annotations for `GET /api/v1/annonces/{id}`, including the path parameter and a 200 response.

## Exercise 3 — Documenting errors (medium)

Complete exercise 2's documentation with the 404 (listing not found) and 401 (unauthenticated, if the route is protected) responses.

## Exercise 4 — Documenting a POST with a request body (medium)

Document `POST /api/v1/annonces` with `@OA\RequestBody` describing the expected fields (`titre`, `prix`, etc.) and their validation constraints.

## Exercise 5 — Introducing a v2 without breaking v1 (hard)

Simulate an evolution: v2 of the API renames the `prix` field to `prix_ttc` and adds `prix_ht`. Implement `V1\AnnonceResource` (keeps `prix`) and `V2\AnnonceResource` (new fields), routed separately (`/api/v1/annonces`, `/api/v2/annonces`), sharing the same underlying controller/model. Document both versions in Swagger.

---

See [solutions/README.md](solutions/README.md) for the answer key.
