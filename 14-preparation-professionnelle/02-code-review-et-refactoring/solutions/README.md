# Corrigé indicatif — 14.2 Code review et refactoring

## Exercice 1

- **Correction** : `Article::find($id)` peut retourner `null` — un appel ensuite sur `$article->titre` provoquerait une erreur fatale si l'ID n'existe pas.
- **Sécurité** : aucune validation des entrées (`$request->titre` pourrait être vide, ou dépasser la taille de la colonne) ; aucune vérification d'autorisation (n'importe quel utilisateur connecté peut modifier n'importe quel article).
- **Lisibilité** : correcte pour un si petit contrôleur, sans problème notable.
- **Cohérence** : `Article::find($id)` plutôt que le Model Binding (`Article $article` en paramètre), qui aurait géré automatiquement le cas "non trouvé" (404) — incohérent avec le reste de la formation depuis le module 06.2.
- **Performance** : sans objet ici.
- **Tests** : aucun test visible pour cette méthode.

## Exercice 2

- "C'est n'importe quoi cette méthode" → "Cette méthode fait à la fois la validation, l'appel à trois services externes et la construction de la réponse — je propose de découper en extrayant au moins l'appel externe dans une classe dédiée, ça faciliterait les tests et la lecture."
- "Utilise un Form Request." → "Cette validation inline est dupliquée dans `store()` et `update()` (mêmes règles) — un Form Request partagé (module 06.6) éviterait cette duplication et centraliserait un futur changement de règle."

## Exercice 3

```php
test('trouverParUtilisateur retourne uniquement les tâches de cet utilisateur, triées par date décroissante', function () {
    // Documente le comportement ACTUEL avant tout refactoring
    $repo = new TacheRepository($pdo);
    $resultat = $repo->trouverParUtilisateur(1);
    expect($resultat)->toBeArray();
    // ... assertions sur l'ordre et le filtrage observés ...
});
```
Une fois ce test vert, la requête SQL interne peut être réécrite (par
exemple, simplifier une concaténation de conditions) tant que le test
reste vert à chaque étape — la preuve que le comportement externe n'a
pas changé, même si l'implémentation, elle, a été améliorée.

## Exercice 4

"Cette boucle déclenche une requête SQL par commande pour charger
`$commande->user` (problème N+1, module 03.6/07.1) — avec 1000 commandes,
c'est 1001 requêtes au lieu de 2. Suggestion : `Order::with('user')->get()`
pour charger la relation en une seule requête supplémentaire, quel que
soit le nombre de commandes."

## Exercice 5

Un exemple de structure de review complète (à adapter au contrôleur choisi) :
```markdown
## Review de AnnonceController

### Correction
RAS — les cas limites (annonce non trouvée, stock insuffisant si applicable)
semblent gérés via le Model Binding et les Form Requests.

### Sécurité
Vérifié : chaque action de modification passe par `$this->authorize()`
ou une Policy — cohérent avec le module 07.5. RAS.

### Lisibilité
`index()` reste lisible malgré la combinaison recherche/filtre/tri/pagination
grâce à `when()` (module 06.7) plutôt qu'un enchaînement de `if`.

### Cohérence
RAS — respecte les conventions Laravel standards du reste du projet.

### Performance
Vérifié : `with(['categorie', 'user'])` présent sur `index()`, évite le N+1.

### Tests
Manque : aucun test ne couvre le cas "recherche + filtre catégorie combinés
simultanément" — suggestion d'ajouter ce cas à la suite existante.
```
