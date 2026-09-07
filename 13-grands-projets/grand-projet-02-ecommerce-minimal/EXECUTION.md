# Exécution

## Lancer les tests (à faire en premier)

```bash
php artisan test --filter=CheckoutTest
```

Les trois tests couvrent : commande réussie (stock décrémenté, panier vidé), stock insuffisant (rien persisté), et rollback complet sur échec de paiement.

## Lancer l'application

```bash
php artisan serve
```

## Utiliser la boutique

1. Parcourez `/produits`, filtrez par catégorie ou recherche.
2. Ajoutez des produits au panier (`/panier`) — fonctionne **sans connexion**.
3. Connectez-vous pour valider la commande (paiement toujours simulé avec succès sauf montant ≤ 0, impossible via l'interface normale).
4. Consultez `/mes-commandes` pour l'historique.

## Utiliser l'administration

Connectez-vous avec le compte promu admin, visitez `/admin/products` : CRUD complet des produits (création, modification, suppression), protégé par le Gate `acceder-admin`.

## Vérifier la transaction en conditions réelles

Modifiez temporairement `FakePaymentGateway::payer()` pour lever systématiquement `PaiementEchoueException`. Passez une commande depuis l'interface : la page affiche l'erreur, et **aucune ligne** n'apparaît dans `orders`/`order_items`, le stock du produit reste inchangé — vérifiable via `php artisan tinker`.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
