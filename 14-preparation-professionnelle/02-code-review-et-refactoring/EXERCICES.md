# Exercices — 14.2 Code review et refactoring

## Exercice 1 — Appliquer la grille de lecture (facile)

Relisez ce code et classez vos observations selon les 6 couches du cours (correction, sécurité, lisibilité, cohérence, performance, tests) :

```php
public function update(Request $request, $id)
{
    $article = Article::find($id);
    $article->titre = $request->titre;
    $article->contenu = $request->contenu;
    $article->save();
    return redirect('/articles');
}
```

## Exercice 2 — Reformuler des commentaires (facile)

Reformulez ces deux commentaires de review pour les rendre constructifs selon le cours : "C'est n'importe quoi cette méthode." / "Utilise un Form Request."

## Exercice 3 — Refactoriser avec des tests comme filet (moyen)

Prenez `TacheRepository` du [mini-projet du niveau 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md). Écrivez d'abord un test de caractérisation pour sa méthode `trouverParUtilisateur()` (documentant son comportement actuel), puis refactorisez son implémentation (par exemple, simplifier la construction de la requête SQL) en vérifiant que le test reste vert à chaque étape.

## Exercice 4 — Détecter un problème N+1 en review (moyen)

Relisez ce code et identifiez le problème de performance, en expliquant comme vous le feriez dans un commentaire de review :
```php
$commandes = Order::all();
foreach ($commandes as $commande) {
    echo $commande->user->name;
}
```

## Exercice 5 — Mener une review complète (difficile)

Choisissez un contrôleur de plus de 50 lignes dans l'un des mini-projets de cette formation (par exemple `AnnonceController` du niveau 07 ou 09). Rédigez une review complète structurée selon les 6 couches du cours, avec au moins un commentaire par couche pertinente (certaines couches peuvent n'avoir "rien à signaler", précisez-le explicitement plutôt que de l'omettre).

---

*(Module réflexif — corrigé indicatif fourni pour orienter votre réflexion.)*

Voir [solutions/README.md](solutions/README.md).
