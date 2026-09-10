# Grand projet : E-commerce minimal

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Construire un e-commerce complet mais **volontairement minimal** : catalogue avec panier en session, tunnel de commande transactionnel (paiement simulé, décrémentation de stock atomique, rollback en cas d'échec), et back-office admin — synthèse de la quasi-totalité des niveaux 02 à 11.

## 📋 Modules mobilisés

- [02.5 — Sessions, cookies](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.md) (panier en session)
- [04.2 — SQL avancé : transactions](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.md) (le cœur du tunnel de commande)
- [07.4/07.5 — Authentification et autorisations](../../07-laravel-intermediaire/README.md) (Breeze, `OrderPolicy`, Gate admin)
- [08.4 — Service Providers](../../08-laravel-avance/04-packages-service-providers-personnalises/README.md) (`PaymentGateway` interchangeable)
- [08.3 — Tests Pest](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md) (tester une transaction et son rollback)

## 🧠 Ce que vous allez apprendre

- Concevoir un panier en session (pas en base) pour permettre l'achat sans compte jusqu'au paiement.
- Encapsuler tout le tunnel de commande (création, décrémentation de stock, paiement) dans une **seule transaction** (`DB::transaction()`), garantissant qu'aucun état incohérent n'est jamais persisté.
- Dénormaliser volontairement `nom_produit`/`prix_unitaire` sur `order_items` pour préserver l'exactitude historique d'une commande, même si le produit change ensuite.
- Injecter une passerelle de paiement **simulée** derrière une interface, remplaçable par un vrai prestataire sans toucher au code appelant.
- Tester explicitement le scénario de rollback : un échec de paiement doit annuler la commande ET restaurer le stock.

## 📂 Structure du projet

```
grand-projet-02-ecommerce-minimal/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/{migrations,factories,seeders}/
├── app/
│   ├── Models/                 # Category, Product, Order, OrderItem
│   ├── Contracts/PaymentGateway.php
│   ├── Services/                 # CartService, OrderService, FakePaymentGateway
│   ├── Exceptions/PaiementEchoueException.php
│   ├── Policies/OrderPolicy.php
│   └── Http/Controllers/           # publics + Admin/ProductController
├── routes/web.php
├── resources/views/
└── tests/Feature/CheckoutTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md).
2. [EXECUTION.md](EXECUTION.md) — **commencez par lancer `CheckoutTest`**, le cœur du projet.
3. **Avant de lire le code fourni**, essayez de concevoir vous-même la transaction de `OrderService::passerCommande()`.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Grand projet : Réseau social minimal](../grand-projet-03-reseau-social-minimal/README.md)
