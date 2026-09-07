# Corrigé indicatif — 14.3 Préparation aux entretiens techniques

## Exercice 1

*"Comment évitez-vous le problème N+1 ?"* — "J'utilise l'eager loading avec `with()`. Concrètement, dans mon mini-projet de blog (module 06), sans `Article::with('categorie')`, afficher 20 articles avec leur catégorie déclenchait 21 requêtes SQL au lieu de 2 — vérifiable avec `DB::listen()`. J'applique systématiquement `whenLoaded()` dans mes API Resources pour éviter la même erreur côté API (module 09.2)."

## Exercice 2

**Situation** : Dans mon mini-projet SaaS multi-utilisateurs (niveau 08), je devais garantir l'isolation des données entre tenants. **Tâche** : m'assurer qu'aucune requête ne puisse accidentellement exposer les données d'un autre tenant. **Action** : j'ai implémenté un scope global Eloquent sur le modèle `Project`, puis écrit une suite de tests dédiée (`IsolationTenantTest`) vérifiant explicitement qu'un utilisateur du tenant A ne peut ni lister ni afficher les projets du tenant B. **Résultat** : les tests ont révélé qu'une requête Query Builder brute (`DB::table()`) contournait le scope — une découverte qui a directement mené à une règle de code documentée pour toute l'équipe.

## Exercice 3

*(Script exemple pour le grand projet E-commerce)* : "J'ai construit un e-commerce minimal pour approfondir la gestion transactionnelle en base de données [Problème]. La décision la plus intéressante concerne le tunnel de commande : toute la logique — création de commande, décrémentation de stock, appel au paiement — est encapsulée dans une seule transaction Laravel, garantissant qu'aucun état incohérent n'est jamais persisté en cas d'échec [Choix technique]. La difficulté principale a été de bien distinguer ce cas d'un projet voisin (mon SaaS de facturation), où un échec de paiement doit AU CONTRAIRE laisser une trace plutôt que tout annuler — ça m'a appris que la même mécanique technique peut cacher deux décisions métier opposées [Difficulté]. Avec plus de temps, j'ajouterais une vraie intégration Stripe pour remplacer ma passerelle simulée [Recul critique]."

## Exercice 4

```php
function motsLesPlusFrequents(string $texte, int $n): array
{
    $mots = str_word_count(strtolower($texte), 1);
    $frequences = array_count_values($mots);
    arsort($frequences);

    return array_slice($frequences, 0, $n, true);
}
```
`array_count_values()` est adapté ici : il compte en O(n) sur le nombre de
mots, une seule passe. `arsort()` trie ensuite en O(m log m) sur le nombre
de mots DISTINCTS (généralement bien plus petit que le texte total).
Complexité globale dominée par le tri : O(m log m).

## Exercice 5

Questions de clarification : (1) Quels canaux sont nécessaires (email, push,
SMS, in-app) ? (2) Les notifications doivent-elles être temps réel ou un
délai de quelques secondes est-il acceptable ? (3) Quel est le pic de
notifications attendu par seconde ? (4) Faut-il un historique consultable,
et pendant combien de temps ? (5) Existe-t-il des préférences utilisateur
(opt-out par canal) à respecter ?

Esquisse de réponse : chaque notification serait distribuée via une Queue
(module 08.1) plutôt que traitée en synchrone, avec plusieurs workers
scalables horizontalement pour absorber le pic. Le canal `database`
(module 07.7) alimenterait un centre de notifications consultable, avec
un cache (module 08.2) sur le compteur de notifications non lues pour
éviter une requête de comptage à chaque affichage de page. Un rate
limiting (module 09.6) protégerait contre l'envoi abusif vers un même
utilisateur en cas de bug d'un service émetteur.
