# Exercices — 07.5 Autorisations : Policies et Gates

## Exercice 1 — Première Policy (facile)

Générez `ArticlePolicy` avec `update`/`delete` limitées à l'auteur. Testez avec `$this->authorize()` dans le contrôleur.

## Exercice 2 — Vérification dans une vue (facile)

Affichez les liens "Modifier"/"Supprimer" sur la page d'un article uniquement avec `@can`/`@cannot`, pour l'utilisateur autorisé.

## Exercice 3 — Gate global (moyen)

Créez un Gate `acceder-admin` limité aux utilisateurs avec `est_admin = true`. Protégez une route `/admin` avec `Route::get(...)->can('acceder-admin')`.

## Exercice 4 — Policy avec règle combinée (moyen)

Modifiez `ArticlePolicy::delete()` pour autoriser soit l'auteur, soit un admin. Testez les trois cas (auteur, admin, tiers).

## Exercice 5 — Form Request délégant à la Policy (difficile)

Réécrivez `UpdateArticleRequest::authorize()` pour déléguer entièrement à `$this->user()->can('update', $this->route('article'))`, en retirant toute logique dupliquée qui existait avant dans le Form Request. Expliquez en commentaire l'avantage de cette centralisation si la règle d'autorisation change un jour.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
