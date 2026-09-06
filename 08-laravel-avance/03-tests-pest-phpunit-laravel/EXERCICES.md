# Exercices — 08.3 Tests avec Pest et PHPUnit dans Laravel

## Exercice 1 — Premier test Feature (facile)

Installez Pest sur le [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md). Écrivez un test vérifiant que `/annonces` répond 200.

## Exercice 2 — Test de création (facile)

Écrivez un test vérifiant qu'un utilisateur connecté peut créer une annonce, avec `assertDatabaseHas()`.

## Exercice 3 — Test d'autorisation (moyen)

Écrivez deux tests : un utilisateur peut modifier sa propre annonce (redirection réussie), un autre utilisateur ne peut pas (403).

## Exercice 4 — Test avec Mail::fake() (moyen)

Écrivez un test vérifiant qu'envoyer un message de contact déclenche bien l'envoi d'une notification, en utilisant `Notification::fake()` et `Notification::assertSentTo()`, sans envoyer de vrai email.

## Exercice 5 — Suite de tests complète pour la Policy (difficile)

Écrivez une suite de tests couvrant TOUS les cas de `AnnoncePolicy` : propriétaire peut modifier, propriétaire peut supprimer, tiers ne peut ni modifier ni supprimer, utilisateur non connecté est redirigé vers la connexion. Utilisez `RefreshDatabase` et vérifiez qu'aucun test n'affecte les suivants (exécutez la suite plusieurs fois de suite, l'ordre des résultats doit être stable).

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
